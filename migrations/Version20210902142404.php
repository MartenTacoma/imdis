<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210902142404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hackathon_contact ADD orcid VARCHAR(19) DEFAULT NULL, ADD bio LONGTEXT DEFAULT NULL, ADD role VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE working_group_contact ADD orcid VARCHAR(19) DEFAULT NULL, ADD bio LONGTEXT DEFAULT NULL, ADD role VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hackathon_contact DROP orcid, DROP bio, DROP role');
        $this->addSql('ALTER TABLE working_group_contact DROP orcid, DROP bio, DROP role');
    }
}
