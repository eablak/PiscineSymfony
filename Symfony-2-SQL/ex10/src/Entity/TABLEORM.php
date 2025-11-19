<?php

namespace App\Entity;

use App\Repository\TABLEORMRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TABLEORMRepository::class)]
class TABLEORM
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $text = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }
}
