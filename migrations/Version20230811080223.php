<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230811080223 extends AbstractMigration
{
  public function getDescription(): string
  {
    return '';
  }

  public function up(Schema $schema): void
  {
    // this up() migration is auto-generated, please modify it to your needs
    $this->addSql('ALTER TABLE journals CHANGE titel titel LONGTEXT DEFAULT NULL');
    $this->addSql('ALTER TABLE records CHANGE titel titel LONGTEXT DEFAULT NULL');
  }

  public function down(Schema $schema): void
  {
    // this down() migration is auto-generated, please modify it to your needs
    $this->addSql('ALTER TABLE journals CHANGE titel titel VARCHAR(255) DEFAULT NULL');
    $this->addSql('ALTER TABLE records CHANGE titel titel VARCHAR(255) DEFAULT NULL');
  }
}
