<?php

namespace App\Entity;

use App\Repository\RecordsRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecordsRepository::class)]
class Records
{
  #[ORM\Id]
  #[ORM\Column(type: 'integer')]
  private ?int $id = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $Titel = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $Auswerter = null;

  #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
  private ?DateTimeInterface $Datum = null;

  #[ORM\ManyToOne(inversedBy: 'records')]
  private ?Journals $Zeitschrift = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(int $id): self
  {
    $this->id = $id;

    return $this;
  }

  public function getTitel(): ?string
  {
    return $this->Titel;
  }

  public function setTitel(?string $Titel): static
  {
    $this->Titel = $Titel;

    return $this;
  }

  public function getAuswerter(): ?string
  {
    return $this->Auswerter;
  }

  public function setAuswerter(?string $Auswerter): static
  {
    $this->Auswerter = $Auswerter;

    return $this;
  }

  public function getDatum(): ?DateTimeInterface
  {
    return $this->Datum;
  }

  public function setDatum(?DateTimeInterface $Datum): static
  {
    $this->Datum = $Datum;

    return $this;
  }

  public function getZeitschrift(): ?Journals
  {
    return $this->Zeitschrift;
  }

  public function setZeitschrift(?Journals $Zeitschrift): static
  {
    $this->Zeitschrift = $Zeitschrift;

    return $this;
  }
}
