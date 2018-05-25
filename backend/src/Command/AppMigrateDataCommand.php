<?php

namespace App\Command;

use App\Service\MigrationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppMigrateDataCommand extends Command
{
    /** @var MigrationService */
    private $migrationService;

    protected static $defaultName = 'app:migrate-data';

    public function __construct(MigrationService $migrationService)
    {
        parent::__construct();
        $this->migrationService = $migrationService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Migrate old database data and fill ')
            ->addOption('truncate-tables', 'tt', InputOption::VALUE_NONE, 'Truncate all actual database tables')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $truncateTables = $input->getOption('truncate-tables');

        if ($truncateTables) {
            $oldUsers = $this->migrationService->getOldDataFromTable('kh_users');
            foreach ($oldUsers as $user) {
                $io->writeln('HAFFFF');
                $io->writeln($user);
            }
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
