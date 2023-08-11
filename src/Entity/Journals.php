<?php

namespace App\Entity;

use App\Repository\JournalsRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: JournalsRepository::class)]
class Journals
{
  #[ORM\Id]
  #[ORM\Column(type: 'integer')]
  private ?int $id;

  #[ORM\Column(type: 'text', nullable: true)]
  private ?string $Titel;

  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private ?string $Auswerter;

  #[ORM\Column(type: 'datetime', nullable: true)]
  #[Assert\DateTime]
  private DateTime $Datum;

  #[ORM\OneToMany(mappedBy: 'Zeitschrift', targetEntity: Records::class)]
  private Collection $records;

  public function __construct()
  {
    $this->records = new ArrayCollection();
  }

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

  /**
   * @return Collection<int, Records>
   */
  public function getRecords(): Collection
  {
    return $this->records;
  }

  public function addRecord(Records $record): static
  {
    if (!$this->records->contains($record)) {
      $this->records->add($record);
      $record->setZeitschrift($this);
    }

    return $this;
  }

  public function removeRecord(Records $record): static
  {
    // set the owning side to null (unless already changed)
    if ($this->records->removeElement($record) && $record->getZeitschrift() === $this) {
      $record->setZeitschrift(null);
    }

    return $this;
  }
}
