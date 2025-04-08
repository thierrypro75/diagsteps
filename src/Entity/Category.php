<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: ProblemType::class, orphanRemoval: true)]
    private Collection $problemTypes;

    public function __construct()
    {
        $this->problemTypes = new ArrayCollection();
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
     * @return Collection<int, ProblemType>
     */
    public function getProblemTypes(): Collection
    {
        return $this->problemTypes;
    }

    public function addProblemType(ProblemType $problemType): static
    {
        if (!$this->problemTypes->contains($problemType)) {
            $this->problemTypes->add($problemType);
            $problemType->setCategory($this);
        }

        return $this;
    }

    public function removeProblemType(ProblemType $problemType): static
    {
        if ($this->problemTypes->removeElement($problemType)) {
            // set the owning side to null (unless already changed)
            if ($problemType->getCategory() === $this) {
                $problemType->setCategory(null);
            }
        }

        return $this;
    }
} 