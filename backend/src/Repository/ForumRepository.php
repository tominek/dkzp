<?php

namespace App\Repository;

use App\Entity\Forum;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Forum|null find($id, $lockMode = null, $lockVersion = null)
 * @method Forum|null findOneBy(array $criteria, array $orderBy = null)
 * @method Forum[]    findAll()
 * @method Forum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Forum::class);
    }

    public function save(Forum $forum, bool $flush = true): void
    {
        $this->_em->persist($forum);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(string $id): void
    {
        $forum = $this->findIfExists($id);
        $this->_em->remove($forum);
        $this->_em->flush();
    }

    public function create(string $subject, string $post, User $user, \DateTime $createdAt, string $type): Forum
    {
        $forum = new Forum($subject, $post, $user, $createdAt, $type);
        $this->save($forum);

        return $forum;
    }

    public function findIfExists(string $id): Forum
    {
        $entity = $this->find($id);
        if (empty($entity)) {
            throw new EntityNotFoundException();
        }
        return $entity;
    }
}