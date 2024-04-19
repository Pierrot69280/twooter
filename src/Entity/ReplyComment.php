<?php

namespace App\Entity;

use AllowDynamicProperties;
use App\Repository\ReplyCommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[AllowDynamicProperties] #[ORM\Entity(repositoryClass: ReplyCommentRepository::class)]
class ReplyComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $replyContent = null;

    #[ORM\ManyToOne(inversedBy: 'ReplyComment')]
    private ?Twoote $twoote = null;

    #[ORM\ManyToOne(inversedBy: 'replyComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Comment $Comment = null;

    #[ORM\ManyToOne(inversedBy: 'replyComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReplyContent(): ?string
    {
        return $this->replyContent;
    }

    public function setReplyContent(?string $replyContent): static
    {
        $this->replyContent = $replyContent;

        return $this;
    }

    public function getTwoote(): ?Twoote
    {
        return $this->twoote;
    }

    public function setTwoote(?Twoote $twoote): static
    {
        $this->twoote = $twoote;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->Comment;
    }

    public function setComment(?Comment $Comment): static
    {
        $this->Comment = $Comment;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}