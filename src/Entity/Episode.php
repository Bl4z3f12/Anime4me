<?php

namespace App\Entity;

use App\Repository\EpisodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: EpisodeRepository::class)]
#[ORM\Table(name: "episode")]
#[Vich\Uploadable]
class Episode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "integer")]
    private int $number;

    #[ORM\ManyToOne(targetEntity: Anime::class, inversedBy: "episodes")]
    #[ORM\JoinColumn(nullable: false)]
    private Anime $anime;

    #[ORM\OneToMany(mappedBy: "episode", targetEntity: Link::class, cascade: ["persist", "remove"])]
    private Collection $links;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $cover;

    #[Vich\UploadableField(mapping: "episode_cover", fileNameProperty: "cover")]
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
        $this->links = new ArrayCollection();
        $this->setUpdatedAt(new \DateTimeImmutable());
        $this->cover = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    public function getAnime(): Anime
    {
        return $this->anime;
    }

    public function setAnime(Anime $anime): void
    {
        $this->anime = $anime;
    }

    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): void
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setEpisode($this);
        }
    }

    public function removeLink(Link $link): void
    {
        if ($this->links->removeElement($link)) {
            if ($link->getEpisode() === $this) {
                $link->setEpisode(null);
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
