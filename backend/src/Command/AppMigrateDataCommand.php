<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Security\UserProvider;
use App\Service\MigrationService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AppMigrateDataCommand extends Command
{
    /** @var MigrationService */
    private $migrationService;

    /** @var UserProvider */
    private $userProvider;

    /** @var CategoryRepository */
    private $categoryRepository;

    protected static $defaultName = 'app:migrate-data';

    public function __construct(
        MigrationService $migrationService,
        UserProvider $userProvider,
        CategoryRepository $categoryRepository
    ) {
        parent::__construct();
        $this->migrationService = $migrationService;
        $this->userProvider = $userProvider;
        $this->categoryRepository = $categoryRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Migrate old database data and fill ')
            ->addOption('truncate-tables', 'tt', InputOption::VALUE_NONE, 'Truncate all actual database tables')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);
        $truncateTables = $input->getOption('truncate-tables');

        if ($truncateTables) {
            $io->writeln('Truncating tables...');
            $this->migrationService->truncateAllTables();
            $io->writeln('Truncate complete!');
        }

        // Users (kh_users)
        $oldUsers = $this->migrationService->getOldDataFromTable('kh_users');
        $i = 1;
        foreach ($oldUsers as $user) {
            if ($user['role'] === 'guest') {
                continue;
            }
            $newUser = new User(
                $user['email'],
                $user['jmeno'],
                $user['prijimeni'],
                $user['psw'],
                [$this->getNewUserRole($user['role'])]
            );
            $this->userProvider->createWithoutFlush($newUser, $i === count($oldUsers));
            $io->writeln(sprintf('Importing user #%d...', $i));
            $i++;
        }

        // Category (kh_kategorie)
        $oldCategories = $this->migrationService->getOldDataFromTable('kh_kategorie');
        $i = 1;
        foreach ($oldCategories as $category) {
            $newCategory = new Category(
                $category['nazev'],
                trim($category['popis']) !== '' ? $category['popis'] : null
            );
            $this->categoryRepository->save($newCategory, $i === count($oldCategories));
            $io->writeln(sprintf('Importing category #%d...', $i));
            $i++;
        }

        $io->success('Migration complete!');
    }

    private function getNewUserRole($string): ?string
    {
        if ($string === 'user') {
            return 'ROLE_USER';
        } elseif ($string === 'admin') {
            return 'ROLE_ADMIN';
        } elseif ($string === 'scan') {
            return 'ROLE_MODERATOR';
        } else {
            return null;
        }
    }
}
