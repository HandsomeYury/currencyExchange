<?php

namespace App\Entity;

use App\Repository\QuoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuoteRepository::class)]
class Quote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $source = null;

    #[ORM\Column(length: 3)]
    private ?string $curCodeFrom = null;

    #[ORM\Column(length: 3)]
    private ?string $curCodeTo = null;

    #[ORM\Column]
    private ?float $rate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getCurCodeFrom(): ?string
    {
        return $this->curCodeFrom;
    }

    public function setCurCodeFrom(string $curCodeFrom): static
    {
        $this->curCodeFrom = $curCodeFrom;

        return $this;
    }

    public function getCurCodeTo(): ?string
    {
        return $this->curCodeTo;
    }

    public function setCurCodeTo(string $curCodeTo): static
    {
        $this->curCodeTo = $curCodeTo;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}
