<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReportRepository")
 */
class Report
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Book", inversedBy="reports")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Book
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reports")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @var string
     */
    private $reason;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $addedAt;

    public function __construct(Book $book, User $user, string $reason, \DateTime $addedAt)
    {
        $this->book = $book;
        $this->user = $user;
        $this->reason = $reason;
        $this->addedAt = $addedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): Report
    {
        $this->book = $book;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Report
    {
        $this->user = $user;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): Report
    {
        $this->reason = $reason;

        return $this;
    }

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    public function setAddedAt(\DateTimeInterface $addedAt): Report
    {
        $this->addedAt = $addedAt;

        return $this;
    }
}
