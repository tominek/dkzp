<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
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

    public function createWithoutFlush(User $user, bool $flush): void
    {
        $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
        $this->userRepository->save($user, $flush);
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
    public function create(string $firstname, string $lastname, string $username, string $password): User
    {
        $user = new User($username, $firstname, $lastname, $password, ['ROLE_USER']);

        $user->setPassword($this->encoder->encodePassword($user, $password));
        $this->userRepository->save($user);

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function loadUserByUsername($username): User
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

    /**
     * @param Request $request
     */
    public function createFromRequest(Request $request)
    {
        try {
            $data = json_decode($request->getContent(), true);
            $this->validateData($data);
            $this->create(
                $data['firstname'],
                $data['lastname'],
                $data['username'],
                $data['password']
            );
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid request body.' . $e->getMessage(), 0, $e);
        }
    }

    private function validateData(array $data)
    {
        $missing = [];
        if (!key_exists('firstname', $data)) $missing[] = 'firstname';
        if (!key_exists('lastname', $data)) $missing[] = 'lastname';
        if (!key_exists('username', $data)) $missing[] = 'username';
        if (!key_exists('password', $data)) $missing[] = 'password';

        if (!empty($missing)) {
            throw new \InvalidArgumentException("Missing required parameters " . implode(", ", $missing) . ".");
        }
    }
}
