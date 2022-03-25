<?php

namespace App\Entity;

use App\Repository\TrainingLessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingLessonRepository::class)]
class TrainingLesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $explanation;

    #[ORM\OneToOne(targetEntity: File::class, cascade: ['persist', 'remove'])]
    private $video;

    #[ORM\OneToMany(mappedBy: 'trainingLesson', targetEntity: File::class)]
    private $files;

    #[ORM\ManyToOne(targetEntity: TrainingSection::class, inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private $trainingSection;

    public function __toString(): string
    {
        return $this->title;
    }

    public function __construct()
    {
        $this->files = new ArrayCollection();
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

    public function getExplanation(): string
    {
        return $this->explanation;
    }

    public function setExplanation(string $explanation): self
    {
        $this->explanation = $explanation;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): self
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return Collection<int, File>
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setTrainingLesson($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getTrainingLesson() === $this) {
                $file->setTrainingLesson(null);
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
        $this->trainingSection = $trainingSection;

        return $this;
    }
}
