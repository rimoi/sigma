<?php

namespace App\Entity;

use App\Repository\AboutRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AboutRepository::class)]
class About
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?File $backgroundImage = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?File $firstFile = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?File $secondFile = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $year = null;

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

    public function getBackgroundImage(): ?File
    {
        return $this->backgroundImage;
    }

    public function setBackgroundImage(?File $backgroundImage): void
    {
        $this->backgroundImage = $backgroundImage;
    }

    public function getFirstFile(): ?File
    {
        return $this->firstFile;
    }

    public function setFirstFile(?File $firstFile): void
    {
        $this->firstFile = $firstFile;
    }

    public function getSecondFile(): ?File
    {
        return $this->secondFile;
    }

    public function setSecondFile(?File $secondFile): void
    {
        $this->secondFile = $secondFile;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): static
    {
        $this->year = $year;

        return $this;
    }
}
