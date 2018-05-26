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
     * @ORM\Column(type="string")
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Book", mappedBy="authors", cascade={"persist"})
     *
     * @var Book[]
     */
    private $books;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
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
     * @param string $key
     * @param \DateTime $born
     * @param \DateTime $died
     */
    public function __construct(string $name, string $description = null, string $key, ?\DateTime $born = null, ?\DateTime $died = null)
    {
        $this->name = $name;
        $this->key = $key;
        $this->books = new ArrayCollection();
        $this->description = $description;
        $this->born = $born;
        $this->died = $died;
    }

    /**
     * @return string
     */
    public function getId(): ?string
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
