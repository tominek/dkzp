<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book implements \JsonSerializable
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     *
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    public $status;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updated;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $downloadCount;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="books")
     * @JoinTable(name="book_category")
     *
     * @var Category[]
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Report", mappedBy="book")
     *
     * @var Report[]
     */
    private $reports;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Author", inversedBy="books")
     * @JoinTable(name="book_author")
     *
     * @var Author[]
     */
    public $authors;

    /**
     * Book constructor.
     *
     * @param string $name
     * @param Author[] $authors
     * @param Category[] $categories
     * @param \DateTime $created
     * @param \DateTime $updated
     * @param int $status
     * @param int $downloadCount
     */
    public function __construct(string $name, array $authors, array $categories, \DateTime $created, \DateTime $updated, int $status = 1, int $downloadCount = 0)
    {
        $this->name = $name;
        $this->authors = new ArrayCollection($authors);
        $this->categories = new ArrayCollection($categories);
        $this->created = $created;
        $this->updated = $updated;
        $this->status = $status;
        $this->downloadCount = $downloadCount;
        $this->reports = new ArrayCollection();
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
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param Category[] $categories
     */
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    public function addCategory(Category $category)
    {
        $this->categories[$category->getId()] = $category;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * @return int
     */
    public function getDownloadCount(): int
    {
        return $this->downloadCount;
    }

    /**
     * @return Author[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function addAuthor(Author $author)
    {
        $this->authors[$author->getId()] = $author;
    }

    function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'downloadCount' => $this->downloadCount,
            'categories' => $this->categories,
            'author' => $this->authors,
            'updated' => $this->updated,
            'created' => $this->created,
            'status' => $this->status
        ];
    }
}
