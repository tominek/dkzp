<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserProvider constructor.
     *
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $encoder)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
    }

    /**
     * Creates and return User.
     *
     * @param string $firstname
     * @param string $lastname
     * @param string $username
     * @param string $password
     *
     * @return User
     */
    public function create(
        string $firstname,
        string $lastname,
        string $username,
        string $password
    ): User {
        $user = new User($username, $firstname, $lastname, $password, ['ROLE_USER']);

        $user->setPassword($this->encoder->encodePassword($user, $password));

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function loadUserByUsername($username)
    {
        $user = $this->userRepository->findOneBy([
            'username' => $username
        ]);
        if (empty($user)) {
            throw new UsernameNotFoundException();
        }
        return $user;
    }

    /**
     * @inheritdoc
     */
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    /**
     * @inheritdoc
     */
    public function supportsClass($class)
    {
        return ($class instanceof User);
    }
}
