<?php

namespace App\Entity;

use App\Repository\JournalsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: JournalsRepository::class)]
class Journals
{
  #[ORM\Id]
  #[ORM\Column(type: 'integer')]
  private ?int $id;

  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private ?string $Titel;

  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private ?string $Auswerter;

  #[ORM\Column(type: 'datetime', nullable: true)]
  #[Assert\DateTime]
  private DateTime $Datum;

  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private ?string $QuellenAuswerter;

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

  public function setTitel(string $Titel): self
  {
    $this->Titel = $Titel;

    return $this;
  }

  public function getAuswerter(): ?string
  {
    return $this->Auswerter;
  }

  public function setAuswerter(string $Auswerter): self
  {
    $this->Auswerter = $Auswerter;

    return $this;
  }

  public function getDatum(): ?DateTime
  {
    return $this->Datum;
  }

  public function setDatum(DateTime $Datum): self
  {
    $this->Datum = $Datum;
    return $this;
  }

  public function getQuellenAuswerter(): ?string
  {
    return $this->QuellenAuswerter;
  }

  public function setQuellenAuswerter(string $QuellenAuswerter): self
  {
    $this->QuellenAuswerter = $QuellenAuswerter;

    return $this;
  }
}
