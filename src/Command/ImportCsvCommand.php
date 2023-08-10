<?php

namespace App\Command;

use App\Controller\JournalImport;
use App\Controller\RecordImport;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 *
 */
#[AsCommand(
  name: 'app:import-csv',
  description: 'Imports a given CSV file into the SPONET-QMQS database.',
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
      ->setHelp('This command allows you to import a CSV file into the SPONET-QMQS database which was exported from SPONET.')
      ->addArgument('file', InputArgument::REQUIRED, 'Path to the file.')
      ->addArgument('type', InputArgument::REQUIRED, 'What type of data?');
  }

  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int
   * @throws InvalidArgument
   * @throws UnavailableStream
   */
  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $io = new SymfonyStyle($input, $output);
    $file = $input->getArgument('file');
    $type = $input->getArgument('type');
    $result = false;

    if (!is_file($file)) {
      return Command::INVALID;
    }

    $io->info('Trying to read: ' . $file);
    $csv = Reader::createFromPath($file);

    $csv->setDelimiter(";");
    $csv->setEnclosure("\"");

    switch ($type) {
      case 'journals':
        $result = (new JournalImport($this->em))->import($csv, $io);
        break;
      case 'records':
        $result = (new RecordImport($this->em))->import($csv, $io);
        break;
    }

    if ($result) {
      return Command::SUCCESS;
    }
    return Command::FAILURE;
  }
}