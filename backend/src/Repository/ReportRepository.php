<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Report;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Report|null find($id, $lockMode = null, $lockVersion = null)
 * @method Report|null findOneBy(array $criteria, array $orderBy = null)
 * @method Report[]    findAll()
 * @method Report[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Report::class);
    }

    public function save(Report $report, bool $flush = true): void
    {
        $this->_em->persist($report);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param int $id
     *
     * @throws EntityNotFoundException
     */
    public function remove(int $id): void
    {
        $report = $this->findIfExists($id);
        $this->_em->remove($report);
        $this->_em->flush();
    }

    public function create(User $user, Book $book, string $reason, \DateTime $addedAt): Report
    {
        $report = new Report($book, $user, $reason, $addedAt);
        $this->save($report);

        return $report;
    }

    /**
     * @param int $id
     *
     * @return Report
     * @throws EntityNotFoundException
     */
    public function findIfExists(int $id): Report
    {
        $entity = $this->find($id);
        if (empty($entity)) {
            throw new EntityNotFoundException();
        }
        return $entity;
    }
}
