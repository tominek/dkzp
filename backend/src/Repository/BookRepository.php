<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param string $id
     *
     * @return Book
     *
     * @throws EntityNotFoundException
     */
    public function findIfExists(string $id): Book
    {
        $book = $this->find($id);
        if (empty($book)) {
            throw new EntityNotFoundException('Book not found.');
        }
        return $book;
    }

    public function create($name, $author, $categories = [])
    {
        $book = new Book($name, $author, $categories, new \DateTime(), new \DateTime());
        $this->save($book);

        return $book;
    }

    public function save(Book $book)
    {
        $this->_em->persist($book);
        $this->_em->flush();
    }
}
