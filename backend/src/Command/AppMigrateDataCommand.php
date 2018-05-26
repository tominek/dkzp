<?php

namespace App\Command;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Forum;
use App\Entity\Report;
use App\Entity\User;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\ForumRepository;
use App\Security\UserProvider;
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

    /** @var UserProvider */
    private $userProvider;

    /** @var CategoryRepository */
    private $categoryRepository;

    /** @var ForumRepository */
    private $forumRepository;

    /** @var BookRepository */
    private $bookRepository;

    /** @var AuthorRepository */
    private $authorRepository;

    protected static $defaultName = 'app:migrate-data';

    public function __construct(
        MigrationService $migrationService,
        UserProvider $userProvider,
        CategoryRepository $categoryRepository,
        ForumRepository $forumRepository,
        BookRepository $bookRepository,
        AuthorRepository $authorRepository
    ) {
        parent::__construct();
        $this->migrationService = $migrationService;
        $this->userProvider = $userProvider;
        $this->categoryRepository = $categoryRepository;
        $this->forumRepository = $forumRepository;
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Migrate old database data and fill ')
            ->addOption('truncate-tables', 'tt', InputOption::VALUE_NONE, 'Truncate all actual database tables');
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

        // User (kh_users)
        $oldUsers = $this->migrationService->getOldDataFromTable('kh_users');
        $iUser = 1;
        foreach ($oldUsers as $user) {
            if ($user['role'] === 'guest') {
                continue;
            }
            $oldUserId = $user['id'];
            $newUser = new User(
                $user['email'],
                $user['jmeno'],
                $user['prijimeni'],
                $user['psw'],
                [$this->getNewUserRole($user['role'])]
            );
            $newUser = $this->userProvider->createWithoutFlush($newUser, true);
            $io->writeln('User gets new ID: ' . $newUser->getId());

            // Forum (kh_forum)
            $oldForum = $this->migrationService->getOldDataFromTableBy('kh_forum', 'user', $oldUserId);
            $i = 1;
            foreach ($oldForum as $item) {
                $dateTime = new \DateTime();
                $dateTime->setTimestamp($item['time']);
                $newForum = new Forum(
                    $item['subject'],
                    $item['text'],
                    $newUser,
                    $dateTime,
                    'SCAN'
                );
                $this->forumRepository->save($newForum, true);
                $io->writeln(sprintf('Importing SCAN FORUM #%d...', $i));
                $i++;
            }

            // Forum (kh_diskuze)
            $oldForum = $this->migrationService->getOldDataFromTableBy('kh_diskuze', 'user', $oldUserId);
            $i = 1;
            foreach ($oldForum as $item) {
                $dateTime = new \DateTime();
                $dateTime->setTimestamp($item['time']);
                $newForum = new Forum(
                    $item['subject'],
                    $item['text'],
                    $newUser,
                    $dateTime,
                    'FORUM'
                );
                $this->forumRepository->save($newForum, true);
                $io->writeln(sprintf('Importing FORUM #%d...', $i));
                $i++;
            }
            $io->writeln(sprintf('Importing USER #%d...', $iUser));
            $iUser++;

            // Reports (kh_hlaseni)
            $oldReports = $this->migrationService->getOldDataFromTableBy('kh_hlaseni', 'uzivatel', $oldUserId);
            $i = 1;
            foreach ($oldReports as $report) {
                $newReport = new Report(
                    $report['kniha'],
                    $report['uzivatel'],
                    $report['duvod'],
                    new \DateTime()
                );
                $this->userProvider->createWithoutFlush($newUser, $i === count($oldUsers));
                $io->writeln(sprintf('Importing REPORT #%d...', $i));
                $i++;
            }
        }

        // Book (kh_knihy)
        $oldBook = $this->migrationService->getOldDataFromTable('kh_knihy');
        $i = 1;
        foreach ($oldBook as $item) {
            $oldBookId = $item['id'];
            $createdAt = new \DateTime();
            $createdAt->setTimestamp($item['pridano']);
            $updatedAt = new \DateTime();
            $updatedAt->setTimestamp($item['upraveno']);

            $newBook = new Book(
                $item['nazev'],
                [],
                [],
                $createdAt,
                $updatedAt
            );

            // Author (kh_prirazeniautori)
            $oldAuthor = $this->migrationService->getOldDataFromTableBy('kh_prirazeniautori', 'book', $oldBookId);
            foreach ($oldAuthor as $authorFromRel) {
                $author = $this->migrationService->getOldDataFromTableBy('kh_autori', 'id', $authorFromRel['autor']);
                $author = $author[0];
                if ($author) {

                    $born = null;
//                        if (isset($author['narozen']) && $author['narozen'] !== null) {
//                            $born = new \DateTime();
//                            $born->setTimestamp(strtotime($author['narozen']));
//                        }
                    $died = null;
//                        if (isset($author['umrti']) && $author['umrti'] !== null) {
//                            $died = new \DateTime();
//                            $died->setTimestamp(strtotime($author['umrti']));
//                        }
                    $newAuthor = $this->authorRepository->findOneBy(['name' => $author['jmeno']]);
                    if (!$newAuthor) {
                        $newAuthor = new Author(
                            $author['jmeno'],
                            $author['description'],
                            $author['klic'],
                            $born,
                            $died
                        );
                    }
                    $newBook->addAuthor($newAuthor);
                    $newAuthor->addBook($newBook);

                    $this->authorRepository->save($newAuthor, false);
                    $io->writeln(sprintf('Importing AUTHOR #%s...', $newAuthor->getId()));
                }
            }

            // Category (kh_prirazenekategorie)
            $oldCategories = $this->migrationService->getOldDataFromTableBy('kh_prirazenekategorie', 'book', $oldBookId);
            foreach ($oldCategories as $categoryFromRel) {
                $category = $this->migrationService->getOldDataFromTableBy('kh_kategorie', 'id', $categoryFromRel['kategorie']);
                $category = $category[0];
                if ($category && trim($category['nazev']) !== '') {
                    $newCategory = $this->authorRepository->findOneBy(['name' => $category['nazev']]);
                    if (!$newCategory) {
                        $newCategory = new Category(
                            $category['nazev'],
                            trim($category['popis']) !== '' ? $category['popis'] : null
                        );
                    }
                    $newCategory->addBook($newBook);
                    $newBook->addCategory($newCategory);
                    $this->categoryRepository->save($newCategory, false);
                    $io->writeln(sprintf('Importing CATEGORY #%s...', $newCategory->getId()));
                }
            }

            $this->bookRepository->save($newBook, true);
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
