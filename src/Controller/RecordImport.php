<?php

namespace App\Controller;

use App\Entity\Journals;
use App\Entity\Records;

/**
 *
 */
class RecordImport extends AbstractImport
{
  /**
   * @param $csv
   * @param $io
   * @return bool
   */
  public function import($csv, $io): bool
  {
    $entries = $csv->getRecords(['id', 'zeitschrift_id', 'titel', 'auswerter', 'datum']);
    if (empty($entries)) {
      return false;
    }

    $io->info('Preparing import statements.');
    foreach ($entries as $entry) {
      if ($this->invalidRow($entry)) {
        continue;
      }
      $entry = $this->convertDate($entry);
      $entry = $this->convertReference($entry);
      $record = $this->em->getRepository(Records::class)->find((int)$entry['id']);
      $journal = $this->em->getRepository(Journals::class)->find((int)$entry['zeitschrift_id']);
      if (!$record) {
        $row = (new Records())
          ->setId((int)$entry['id'])
          ->setZeitschrift($journal)
          ->setTitel($entry['titel'])
          ->setAuswerter($entry['auswerter'])
          ->setDatum($entry['datum']);
      } else {
        $row = $record
          ->setZeitschrift($journal)
          ->setTitel($entry['titel'])
          ->setAuswerter($entry['auswerter'])
          ->setDatum($entry['datum']);
      }
      $this->em->persist($row);
    }
    $io->info('Trying to import data.');
    $this->em->flush();

    $io->success('Import finished!');
    return true;
  }

  /**
   * Cleans strange reference to journal. E.g. Objekt 9633 / SPONET5 >> 9633
   * @param $entry
   * @return array
   */
  protected function convertReference($entry): array
  {
    if ($entry['zeitschrift_id'] === "") {
      $entry['zeitschrift_id'] = null;
    } else {
      preg_match('/\d{2,100}/', $entry['zeitschrift_id'], $matches);
      $entry['zeitschrift_id'] = (int)$matches[0];
    }
    return $entry;
  }
}