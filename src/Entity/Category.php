<?php


namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Twoote::class, mappedBy: "category")]
    private Collection $twoote;

    #[ORM\ManyToOne(inversedBy: 'categorys')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    public function __construct()
    {
        $this->twoote = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Twoote>
     */
    public function getTwoote(): Collection
    {
        return $this->twoote;
    }

    public function addTwoote(Twoote $twoote): static
    {
        if (!$this->twoote->contains($twoote)) {
            $this->twoote->add($twoote);
            $twoote->setCategory($this);
        }

        return $this;
    }

    public function removeTwoote(Twoote $twoote): static
    {
        if ($this->twoote->removeElement($twoote)) {
            // set the owning side to null (unless already changed)
            if ($twoote->getCategory() === $this) {
                $twoote->setCategory(null);
            }
        }

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
}
