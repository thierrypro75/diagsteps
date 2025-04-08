<?php

namespace App\Entity;

use App\Repository\ProblemTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ProblemTypeRepository::class)]
class ProblemType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'problemTypes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'problemType', targetEntity: DiagnosticSteps::class)]
    private Collection $diagnosticSteps;

    public function __construct()
    {
        $this->diagnosticSteps = new ArrayCollection();
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return Collection<int, DiagnosticSteps>
     */
    public function getDiagnosticSteps(): Collection
    {
        return $this->diagnosticSteps;
    }

    public function addDiagnosticStep(DiagnosticSteps $diagnosticStep): static
    {
        if (!$this->diagnosticSteps->contains($diagnosticStep)) {
            $this->diagnosticSteps->add($diagnosticStep);
            $diagnosticStep->setProblemType($this);
        }
        return $this;
    }

    public function removeDiagnosticStep(DiagnosticSteps $diagnosticStep): static
    {
        if ($this->diagnosticSteps->removeElement($diagnosticStep)) {
            if ($diagnosticStep->getProblemType() === $this) {
                $diagnosticStep->setProblemType(null);
            }
        }
        return $this;
    }
} 