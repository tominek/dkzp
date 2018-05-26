<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category implements \JsonSerializable
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
     * @ORM\Column(type="string", length=64)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Book", mappedBy="categories")
     *
     * @var Book[]
     */
    private $books;

    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
        $this->books = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return Book[]
     */
    public function getBooks(): array
    {
        return $this->books;
    }

    /**
     * @param Book[] $books
     */
    public function setBooks(array $books)
    {
        $this->books = $books;
    }

    public function addBook(Book $book)
    {
        $this->books[] = $book;
    }

    function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'books' => $this->books
        ];
    }
}
