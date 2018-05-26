<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user, bool $flush = true): void
    {
        $this->_em->persist($user);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param string $id
     *
     * @throws EntityNotFoundException
     */
    public function enableUser(string $id)
    {
        $user = $this->findIfExists($id);
        $user->enable();
        $this->save($user);
    }

    /**
     * @param string $id
     *
     * @throws EntityNotFoundException
     */
    public function disableUser(string $id)
    {
        $user = $this->findIfExists($id);
        $user->disable();
        $this->save($user);
    }

    public function findIfExists(int $id): User
    {
        $entity = $this->find($id);
        if (empty($entity)) {
            throw new EntityNotFoundException();
        }
        return $entity;
    }
}
