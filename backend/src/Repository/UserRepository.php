<?php

namespace App\Repository;

use App\Entity\User;
use App\Repository\Exception\UserNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function save(User $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param string $id
     *
     * @throws UserNotFoundException
     */
    public function enableUser(string $id)
    {
        $user = $this->find($id);
        if (empty($user)) {
            throw new UserNotFoundException();
        }
        $user->enable();
        $this->save($user);
    }

    /**
     * @param string $id
     *
     * @throws UserNotFoundException
     */
    public function disableUser(string $id)
    {
        $user = $this->find($id);
        if (empty($user)) {
            throw new UserNotFoundException();
        }
        $user->disable();
        $this->save($user);
    }
}
