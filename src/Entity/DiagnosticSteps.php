<?php

namespace App\Entity;

use App\Repository\DiagnosticStepsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DiagnosticStepsRepository::class)]
#[ORM\Table(name: 'diagnostic_steps')]
class DiagnosticSteps
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['symptome', 'check', 'action'])]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', nullable: true)]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private \Doctrine\Common\Collections\Collection $children;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'next_step_id', referencedColumnName: 'id', nullable: true)]
    private ?self $nextStep = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?int $ordre = null;

    #[ORM\ManyToOne(inversedBy: 'diagnosticSteps')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProblemType $problemType = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $goto = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'next_step_ko_id', referencedColumnName: 'id', nullable: true)]
    private ?self $nextStepKo = null;

    #[ORM\Column(type: 'boolean')]
    private bool $needDoc = false;

    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection<int, self>
     */
    public function getChildren(): \Doctrine\Common\Collections\Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }
        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }
        return $this;
    }

    public function getNextStep(): ?self
    {
        return $this->nextStep;
    }

    public function setNextStep(?self $nextStep): self
    {
        $this->nextStep = $nextStep;
        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;
        return $this;
    }

    public function getProblemType(): ?ProblemType
    {
        return $this->problemType;
    }

    public function setProblemType(?ProblemType $problemType): self
    {
        $this->problemType = $problemType;
        return $this;
    }

    public function getGoto(): ?int
    {
        return $this->goto;
    }

    public function setGoto(?int $goto): self
    {
        $this->goto = $goto;
        return $this;
    }

    public function getNextStepKo(): ?self
    {
        return $this->nextStepKo;
    }

    public function setNextStepKo(?self $nextStepKo): self
    {
        $this->nextStepKo = $nextStepKo;
        return $this;
    }

    public function isNeedDoc(): bool
    {
        return $this->needDoc;
    }

    public function setNeedDoc(bool $needDoc): self
    {
        $this->needDoc = $needDoc;
        return $this;
    }
} 