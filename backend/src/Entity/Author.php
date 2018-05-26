<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author implements \JsonSerializable
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
     * @ORM\Column(type="string", unique=true)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=false, name="first_letter")
     *
     * @var string
     */
    private $key;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Book", mappedBy="author")
     *
     * @var Book[]
     */
    private $books;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @var \DateTime
     */
    private $born;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $died;

    /**
     * Author constructor.
     *
     * @param string $name
     * @param string $description
     * @param \DateTime $born
     * @param \DateTime $died
     */
    public function __construct(string $name, string $description = null, \DateTime $born, \DateTime $died = null)
    {
        $this->name = $name;
        preg_match('/^(Ch|\w).*/', $name, $key);
        $this->key = $key[1];
        $this->books = new ArrayCollection();
        $this->description = $description;
        $this->born = $born;
        $this->died = $died;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return Book[]
     */
    public function getBooks(): array
    {
        return $this->books;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return \DateTime
     */
    public function getBorn(): \DateTime
    {
        return $this->born;
    }

    /**
     * @return \DateTime
     */
    public function getDied(): \DateTime
    {
        return $this->died;
    }

    /**
     * @param \DateTime $died
     */
    public function setDied(\DateTime $died): void
    {
        $this->died = $died;
    }

    public function addBook(Book $book)
    {
        $this->books[] = $book;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'key' => $this->key,
            'books' => $this->books,
            'description' => $this->description,
            'born' => $this->born->format('d/m/Y'),
            'died' => ($this->died) ? $this->died->format('d/m/Y') : '',
        ];
    }
}
