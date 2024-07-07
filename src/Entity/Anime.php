<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "anime")]
#[Vich\Uploadable]
class Anime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $title;

    #[ORM\Column(type: "text")]
    private string $description;

    #[ORM\OneToMany(mappedBy: "anime", targetEntity: Episode::class, cascade: ["persist", "remove"])]
    private Collection $episodes;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $cover = null;

    #[Vich\UploadableField(mapping: "anime_cover", fileNameProperty: "cover")]
    #[Assert\File(
        maxSize: "5M",
        mimeTypes: ["image/jpeg", "image/png", "image/webp"],
        mimeTypesMessage: "Please upload a valid image."
    )]
    private ?File $coverFile = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->episodes = new ArrayCollection();
        $this->setUpdatedAt(new \DateTimeImmutable());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episode $episode): void
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
            $episode->setAnime($this);
        }
    }

    public function removeEpisode(Episode $episode): void
    {
        if ($this->episodes->removeElement($episode)) {
            if ($episode->getAnime() === $this) {
                $episode->setAnime(null);
            }
        }
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): void
    {
        $this->cover = $cover;
    }

    public function setCoverFile(?File $coverFile = null): void
    {
        $this->coverFile = $coverFile;

        if (null !== $coverFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getCoverFile(): ?File
    {
        return $this->coverFile;
    }
}
