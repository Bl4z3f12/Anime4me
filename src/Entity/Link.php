<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "link")]
class Link
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $url;

    #[ORM\ManyToOne(targetEntity: Episode::class, inversedBy: "links")]
    #[ORM\JoinColumn(nullable: false)]
    private Episode $episode;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getEpisode(): Episode
    {
        return $this->episode;
    }

    public function setEpisode(Episode $episode): void
    {
        $this->episode = $episode;
    }
}
