<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

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
     *
     * @throws \InvalidArgumentException
     */
    public function createFromRequest(Request $request)
    {
        try {
            $data = json_decode($request->getContent(), true);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid request body. ' . $e->getMessage());
        }
        $this->validateCreateData($data);
        $this->create(
            $data['firstname'],
            $data['lastname'],
            $data['username'],
            $data['password']
        );
    }

    /**
     * @param array $data
     *
     * @throws \InvalidArgumentException
     */
    private function validateCreateData(array $data)
    {
        $validator = Validation::createValidator();

        $constraint = new Assert\Collection(array(
            'firstname' => new Assert\NotBlank(),
            'lastname' => new Assert\NotBlank(),
            'username' => new Assert\Email(),
            'password' => new Assert\Length(array('min' => 8))
        ));

        $violations = $validator->validate($data, $constraint);

        if ($violations->count() > 0) {
            throw new \InvalidArgumentException("Missing required parameters. Required: firstname, lastname, username, password");
        }
    }
}
