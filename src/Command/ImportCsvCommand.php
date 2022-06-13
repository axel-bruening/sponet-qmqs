<?php

namespace App\Command;

use App\Entity\Journals;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
  name: 'app:import-csv',
  description: 'Imports a given CSV file into the database.',
  hidden: false
)]
class ImportCsvCommand extends Command
{

  /**
   * @var EntityManagerInterface
   */
  private EntityManagerInterface $em;

  /**
   * @param EntityManagerInterface $em
   */
  public function __construct(EntityManagerInterface $em)
  {
    parent::__construct();

    $this->em = $em;
  }

  /**
   * @return void
   */
  protected function configure(): void
  {
    $this
      ->setHelp('This command allows you to import a CSV file into the database which was exported from SPONET with format CSV-ZS.')
      ->addArgument('file', InputArgument::REQUIRED, 'Path to the file.');
  }

  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int
   * @throws InvalidArgument
   */
  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $io = new SymfonyStyle($input, $output);
    $file = $input->getArgument('file');

    if (!is_file($file)) return Command::INVALID;

    $io->info('Trying to read: ' . $file);
    $csv = Reader::createFromPath($file);
    $csv->setDelimiter(";");
    $csv->setEnclosure("\"");
    $records = $csv->getRecords(['id', 'titel', 'auswerter', 'datum']);
    if (empty($records)) return Command::FAILURE;

    $io->info('Preparing import statements.');
    foreach ($records as $record) {
      if ($this->invalidRow($record)) continue;
      $record = $this->convertDate($record);
      $journal = $this->em->getRepository(Journals::class)->find((int)$record['id']);
      if (!$journal) {
        if (gettype($record['datum']) == "boolean") {
          $io->error("Erfassungsdatum von ID: $record[id] ist fehlerhaft");
          return Command::FAILURE;
        }
        $row = (new Journals())
          ->setId((int)$record['id'])
          ->setTitel($record['titel'])
          ->setAuswerter($record['auswerter'])
          ->setDatum($record['datum']);
      } else {
        $row = $journal
          ->setTitel($record['titel'])
          ->setAuswerter($record['auswerter'])
          ->setDatum($record['datum']);
      }
      $this->em->persist($row);
    }
    $io->info('Trying to import data.');
    $this->em->flush();

    $io->success('Import finished!');
    return Command::SUCCESS;
  }

  /**
   * @param $record
   * @return bool
   */
  protected function invalidRow($record): bool
  {
    return empty($record['id']);
  }

  protected function convertDate($record): array
  {
    $record['datum'] = \DateTime::createFromFormat('d.m.Y', $record['datum']);
    return $record;
  }

}