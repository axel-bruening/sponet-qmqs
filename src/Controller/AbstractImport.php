<?php

namespace App\Controller;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractImport
{
  /**
   * @var EntityManagerInterface
   */
  protected EntityManagerInterface $em;

  /**
   * @param EntityManagerInterface $em
   */
  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }

  /**
   * Implement method stub for importing data
   * @param $csv
   * @param $io
   * @return bool
   */

  abstract public function import($csv, $io): bool;


  /**
   * @param $entry
   * @return bool
   */
  protected function invalidRow($entry): bool
  {
    return empty($entry['id']);
  }

  /**
   * @param $entry
   * @return array
   */
  protected function convertDate($entry): array
  {
    if ($entry['datum'] === "") {
      $entry['datum'] = "01.01.1900";
    }
    $entry['datum'] = DateTime::createFromFormat('d.m.Y', $entry['datum']);
    return $entry;
  }
}