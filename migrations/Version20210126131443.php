<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126131443 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abstract_person ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE committee_person ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE presentation_person ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE session_chair ADD name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abstract_person DROP name');
        $this->addSql('ALTER TABLE committee_person DROP name');
        $this->addSql('ALTER TABLE presentation_person DROP name');
        $this->addSql('ALTER TABLE session_chair DROP name');
    }
}
