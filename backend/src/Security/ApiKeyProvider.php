<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiKeyProvider implements UserProviderInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * ApiKeyProvider constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritdoc
     */
    public function loadUserByUsername($username): User
    {
        $user = $this->userRepository->findOneBy([
            'apiKey' => $username
        ]);
        if (empty($user)) {
            throw new UsernameNotFoundException();
        }
        return $user;
    }

    /**
     * @inheritdoc
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    /**
     * @inheritdoc
     */
    public function supportsClass($class): bool
    {
        return ($class instanceof User);
    }
}
