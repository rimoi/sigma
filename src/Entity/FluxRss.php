<?php

namespace App\Entity;

use App\Repository\FluxRssRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FluxRssRepository::class)]
class FluxRss
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $link = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $classFontAwesome = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getClassFontAwesome(): ?string
    {
        return $this->classFontAwesome;
    }

    public function setClassFontAwesome(?string $classFontAwesome): static
    {
        $this->classFontAwesome = $classFontAwesome;

        return $this;
    }
}
