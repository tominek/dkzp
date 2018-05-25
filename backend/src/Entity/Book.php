<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Book implements \JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public $name;

    /**
     * @ORM\Column(type="boolean")
     */
    public $state;

    /**
     * @ORM\Column(type="datetime")
     */
    public $created;

    /**
     * @ORM\Column(type="datetime")
     */
    public $updated;

    /**
     * @ORM\Column(type="integer")
     */
    public $downloadCount;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="books")
     *
     * @var Category[]
     */
    public $categories;

    /**
     * Book constructor.
     *
     * @param string $name
     * @param \DateTime $created
     * @param \DateTime $updated
     * @param int $state
     * @param int $downloadCount
     * @param array $categories
     */
    public function __construct(string $name, \DateTime $created, \DateTime $updated, int $state = 1, int $downloadCount = 0, array $categories = [])
    {
        $this->name = $name;
        $this->created = $created;
        $this->updated = $updated;
        $this->state = $state;
        $this->downloadCount = $downloadCount;
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
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

    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'downloadCount' => $this->downloadCount,
            'categories' => $this->categories,
            'updated' => $this->updated,
            'created' => $this->created,
            'state' => $this->state
        ];
    }
}
