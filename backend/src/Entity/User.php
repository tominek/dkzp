<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements AdvancedUserInterface, \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     *
     * @var string
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
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Report", mappedBy="user")
     */
    private $reports;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Book", cascade={"persist", "remove"})
     *
     * @var Book[]
     */
    private $favoriteBooks;

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
        $this->roles = $roles;
        $this->registrationDate = new \DateTime();
        $this->enabled = false;
        $this->reports = new ArrayCollection();
        $this->favoriteBooks = new ArrayCollection();
    }

    public function addFavoriteBook(Book $book)
    {
        $this->favoriteBooks[] = $book;
    }

    public function removeFavoriteBook(Book $book)
    {
        $this->favoriteBooks->removeElement($book);
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
            'favoriteBooks' => $this->favoriteBooks->toArray()
        ];
    }

    /**
     * @inheritdoc
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    public function enable()
    {
        $this->enabled = true;
    }

    public function disable()
    {
        $this->enabled = false;
    }

    /**
     * @return Collection|Report[]
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Report $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports[] = $report;
            $report->setUser($this);
        }

        return $this;
    }

    public function removeReport(Report $report): self
    {
        if ($this->reports->contains($report)) {
            $this->reports->removeElement($report);
            // set the owning side to null (unless already changed)
            if ($report->getUser() === $this) {
                $report->setUser(null);
            }
        }

        return $this;
    }
}
