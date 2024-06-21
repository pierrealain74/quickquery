<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, QuestionTag>
     */
    #[ORM\OneToMany(targetEntity: QuestionTag::class, mappedBy: 'tag')]
    private Collection $questionTags;

    public function __construct()
    {
        $this->questionTags = new ArrayCollection();
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
     * @return Collection<int, QuestionTag>
     */
    public function getQuestionTags(): Collection
    {
        return $this->questionTags;
    }

    public function addQuestionTag(QuestionTag $questionTag): static
    {
        if (!$this->questionTags->contains($questionTag)) {
            $this->questionTags->add($questionTag);
            $questionTag->setTag($this);
        }

        return $this;
    }

    public function removeQuestionTag(QuestionTag $questionTag): static
    {
        if ($this->questionTags->removeElement($questionTag)) {
            // set the owning side to null (unless already changed)
            if ($questionTag->getTag() === $this) {
                $questionTag->setTag(null);
            }
        }

        return $this;
    }
}
