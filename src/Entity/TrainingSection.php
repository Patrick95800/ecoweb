<?php

namespace App\Entity;

use App\Repository\TrainingSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingSectionRepository::class)]
class TrainingSection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\ManyToOne(targetEntity: Training::class, inversedBy: 'sections')]
    #[ORM\JoinColumn(nullable: false)]
    private $training;

    #[ORM\OneToMany(mappedBy: 'trainingSection', targetEntity: TrainingLesson::class, orphanRemoval: true)]
    private $lessons;

    #[ORM\OneToOne(inversedBy: 'trainingSection', targetEntity: Quizz::class, cascade: ['persist', 'remove'])]
    private $quizz;

    public function __toString(): string
    {
        return sprintf('%s - %s', $this->training->getTitle(), $this->title);
    }

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

        return $this;
    }

    /**
     * @return Collection<int, TrainingLesson>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(TrainingLesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons[] = $lesson;
            $lesson->setTrainingSection($this);
        }

        return $this;
    }

    public function removeLesson(TrainingLesson $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getTrainingSection() === $this) {
                $lesson->setTrainingSection(null);
            }
        }

        return $this;
    }

    public function getQuizz(): ?Quizz
    {
        return $this->quizz;
    }

    public function setQuizz(?Quizz $quizz): self
    {
        $this->quizz = $quizz;

        return $this;
    }
}
