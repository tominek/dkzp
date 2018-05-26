<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
     * @param string $id
     *
     * @return Author
     *
     * @throws EntityNotFoundException
     */
    public function findIfExists(string $id): Author
    {
        $author = $this->find($id);
        if (empty($author)) {
            throw new EntityNotFoundException('Author not found.');
        }
        return $author;
    }

    public function save(Author $author, bool $flush = true)
    {
        $this->_em->persist($author);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param string $name
     * @param string $description
     * @param \DateTime $born
     * @param \DateTime|null $died
     *
     * @return Author
     */
    public function create(string $name, string $description, \DateTime $born, \DateTime $died = null): Author
    {
        $author = new Author($name, $description, $born, $died);
        $this->save($author);

        return $author;
    }
}
