<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230810075620 extends AbstractMigration
{
  public function getDescription(): string
  {
    return '';
  }

  public function up(Schema $schema): void
  {
    // this up() migration is auto-generated, please modify it to your needs
    $this->addSql('CREATE TABLE records (id INT AUTO_INCREMENT NOT NULL, zeitschrift_id INT DEFAULT NULL, titel VARCHAR(255) DEFAULT NULL, auswerter VARCHAR(255) DEFAULT NULL, datum DATETIME DEFAULT NULL, INDEX IDX_9C9D5846458200DC (zeitschrift_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    $this->addSql('ALTER TABLE records ADD CONSTRAINT FK_9C9D5846458200DC FOREIGN KEY (zeitschrift_id) REFERENCES journals (id)');
    $this->addSql('ALTER TABLE record DROP FOREIGN KEY FK_9B349F91458200DC');
    $this->addSql('DROP TABLE record');
  }

  public function down(Schema $schema): void
  {
    // this down() migration is auto-generated, please modify it to your needs
    $this->addSql('CREATE TABLE record (id INT AUTO_INCREMENT NOT NULL, zeitschrift_id INT DEFAULT NULL, titel VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, auswerter VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, datum DATETIME DEFAULT NULL, INDEX IDX_9B349F91458200DC (zeitschrift_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
    $this->addSql('ALTER TABLE record ADD CONSTRAINT FK_9B349F91458200DC FOREIGN KEY (zeitschrift_id) REFERENCES journals (id)');
    $this->addSql('ALTER TABLE records DROP FOREIGN KEY FK_9C9D5846458200DC');
    $this->addSql('DROP TABLE records');
  }
}
