<?php

namespace App\Entity;

use AllowDynamicProperties;
use App\Repository\TwooteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[AllowDynamicProperties] #[ORM\Entity(repositoryClass: TwooteRepository::class)]
class Twoote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private ?string $content = null;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'twoote', cascade: ['remove'])]
    private Collection $comments;

    #[ORM\OneToMany(targetEntity: ReplyComment::class, mappedBy: 'twoote')]
    private Collection $replies;

    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'twoote', orphanRemoval: true)]
    private Collection $images;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'retwoot_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    private ?self $retwoot = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'twootes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: "twoote")]
    private Collection $category;

    #[ORM\OneToMany(targetEntity: Like::class, mappedBy: 'twoote', cascade: ['remove'])]
    private Collection $likes;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $achetag = null;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->replies = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTwoote($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTwoote() === $this) {
                $comment->setTwoote(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReplyComment>
     */
    public function getReplies(): Collection
    {
        return $this->replies;
    }

    public function addReply(ReplyComment $reply): static
    {
        if (!$this->replies->contains($reply)) {
            $this->replies->add($reply);
            $reply->setTwoote($this);
        }

        return $this;
    }

    public function removeReply(ReplyComment $reply): static
    {
        if ($this->replies->removeElement($reply)) {
            // set the owning side to null (unless already changed)
            if ($reply->getTwoote() === $this) {
                $reply->setTwoote(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setTwoote($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getTwoote() === $this) {
                $image->setTwoote(null);
            }
        }

        return $this;
    }

    public function getRetwoot(): ?self
    {
        return $this->retwoot;
    }

    public function setRetwoot(?self $retwoot): static
    {
        $this->retwoot = $retwoot;

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


    public function removeCategory(Category $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
            $category->addTwoote($this);
        }
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
            $like->setTwoote($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getTwoote() === $this) {
                $like->setTwoote(null);
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
