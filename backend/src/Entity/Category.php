<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Book", inversedBy="groups")
     *
     * @var Book[]
     */
    private $books;

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): Category
    {
        $this->name = $name;

        return $this;
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
    public function setBooks(array $books): void
    {
        $this->books = $books;
    }

    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'books' => $this->books
        ];
    }
}