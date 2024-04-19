<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Twoote $twoote = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\OneToMany(targetEntity: ReplyComment::class, mappedBy: 'Comment', orphanRemoval: true)]
    private Collection $replyComments;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\OneToMany(targetEntity: Like::class, mappedBy: 'comment', cascade: ['remove'])]
    private Collection $likes;


    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->replyComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, ReplyComment>
     */
    public function getReplyComments(): Collection
    {
        return $this->replyComments;
    }

    public function addReplyComment(ReplyComment $replyComment): static
    {
        if (!$this->replyComments->contains($replyComment)) {
            $this->replyComments->add($replyComment);
            $replyComment->setComment($this);
        }

        return $this;
    }

    public function removeReplyComment(ReplyComment $replyComment): static
    {
        if ($this->replyComments->removeElement($replyComment)) {
            // set the owning side to null (unless already changed)
            if ($replyComment->getComment() === $this) {
                $replyComment->setComment(null);
            }
        }

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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setComment($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getComment() === $this) {
                $like->setComment(null);
            }
        }
        return $this;
    }

    public function isLikedBy(User $user):bool
    {
        $isLiked = false;
        foreach ($this->likes as $like)
        {
            if($like->getAuthor() === $user)
            {
                $isLiked = true;
            }
        }
        return $isLiked;
    }
}
