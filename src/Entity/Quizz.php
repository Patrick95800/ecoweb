<?php

namespace App\Entity;

use App\Repository\QuizzRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizzRepository::class)]
class Quizz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'quizz', targetEntity: Question::class, orphanRemoval: true, cascade: ['persist'])]
    private $questions;

    #[ORM\OneToOne(mappedBy: 'quizz', targetEntity: TrainingSection::class, cascade: ['persist', 'remove'])]
    private $trainingSection;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setQuizz($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuizz() === $this) {
                $question->setQuizz(null);
            }
        }

        return $this;
    }

    public function getTrainingSection(): ?TrainingSection
    {
        return $this->trainingSection;
    }

    public function setTrainingSection(?TrainingSection $trainingSection): self
    {
        // unset the owning side of the relation if necessary
        if ($trainingSection === null && $this->trainingSection !== null) {
            $this->trainingSection->setQuizz(null);
        }

        // set the owning side of the relation if necessary
        if ($trainingSection !== null && $trainingSection->getQuizz() !== $this) {
            $trainingSection->setQuizz($this);
        }

        $this->trainingSection = $trainingSection;

        return $this;
    }
}
