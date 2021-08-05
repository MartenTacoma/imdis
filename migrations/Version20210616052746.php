<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210616052746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hackathon_session ADD time_end TIME NOT NULL, ADD meeting_url VARCHAR(255) DEFAULT NULL, ADD meeting_id VARCHAR(255) DEFAULT NULL, ADD meeting_passcode VARCHAR(255) DEFAULT NULL, CHANGE time time_start TIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hackathon_session ADD time TIME NOT NULL, DROP time_start, DROP time_end, DROP meeting_url, DROP meeting_id, DROP meeting_passcode');
    }
}
