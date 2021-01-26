<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210122121022 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poster ADD abstract_id INT NOT NULL');
        $this->addSql('ALTER TABLE poster ADD CONSTRAINT FK_2D710CF2D56B77AA FOREIGN KEY (abstract_id) REFERENCES imdis_abstract (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D710CF2D56B77AA ON poster (abstract_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poster DROP FOREIGN KEY FK_2D710CF2D56B77AA');
        $this->addSql('DROP INDEX UNIQ_2D710CF2D56B77AA ON poster');
        $this->addSql('ALTER TABLE poster DROP abstract_id');
    }
}
