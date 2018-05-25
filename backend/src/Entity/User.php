<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * User email is used as username.
     *
     * @ORM\Column(type="string", unique=true)
     *
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $firstname;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $lastname;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="simple_array")
     *
     * @var string[]
     */
    private $roles;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $registrationDate;

    /**
     * User constructor.
     *
     * @param string $username
     * @param string $firstname
     * @param string $lastname
     * @param string $password
     * @param array $roles
     */
    public function __construct(string $username, string $firstname, string $lastname, string $password, array $roles = ['ROLE_USER'])
    {
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->registrationDate = new \DateTime();
        $this->roles = $roles;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @inheritdoc
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @inheritdoc
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @inheritdoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return \DateTime
     */
    public function getRegistrationDate(): \DateTime
    {
        return $this->registrationDate;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @inheritdoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'username' => $this->username,
            'roles' => $this->roles,
        ];
    }
}
