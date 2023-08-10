<?php

namespace App\Controller;

use App\Entity\Journals;

/**
 *
 */
class JournalImport extends AbstractImport
{
  /**
   * @param $csv
   * @param $io
   * @return bool
   */

  public function import($csv, $io): bool
  {
    $entries = $csv->getRecords(['id', 'titel', 'auswerter', 'datum']);
    if (empty($entries)) {
      return false;
    }

    $io->info('Preparing import statements.');
    foreach ($entries as $entry) {
      if ($this->invalidRow($entry)) {
        continue;
      }
      $entry = $this->convertDate($entry);
      $journal = $this->em->getRepository(Journals::class)->find((int)$entry['id']);
      if (!$journal) {
        $row = (new Journals())
          ->setId((int)$entry['id'])
          ->setTitel($entry['titel'])
          ->setAuswerter($entry['auswerter'])
          ->setDatum($entry['datum']);
      } else {
        $row = $journal
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
}