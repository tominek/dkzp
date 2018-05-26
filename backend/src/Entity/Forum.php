<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ForumRepository")
 */
class Forum implements \JsonSerializable
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
     * @ORM\Column(type="string", length=128)
     *
     * @var string
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=16)
     *
     * @var string
     */
    private $type;

    public function __construct(string $subject, string $post, User $user, \DateTime $createdAt, string $type)
    {
        $this->subject = $subject;
        $this->post = $post;
        $this->user = $user;
        $this->createdAt = $createdAt;
        $this->type = $type;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): Forum
    {
        $this->subject = $subject;

        return $this;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(string $post): Forum
    {
        $this->post = $post;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Forum
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): Forum
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): Forum
    {
        $this->type = $type;

        return $this;
    }

    function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'post' => $this->post,
            'user' => $this->user,
            'createdAt' => $this->createdAt,
        ];
    }
}