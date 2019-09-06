<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190902143148 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX libelle ON article');
        $this->addSql('ALTER TABLE article RENAME INDEX fk_category_id TO IDX_23A0E6612469DE2');
        $this->addSql('ALTER TABLE category CHANGE category name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX libelle ON article (libelle)');
        $this->addSql('ALTER TABLE article RENAME INDEX idx_23a0e6612469de2 TO fk_category_id');
        $this->addSql('ALTER TABLE category CHANGE name category VARCHAR(255) NOT NULL COLLATE utf8_bin');
    }
}
