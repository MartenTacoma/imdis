<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210616103549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presentation ADD hackathon_id INT DEFAULT NULL, ADD time_end TIME DEFAULT NULL, ADD meeting_url VARCHAR(255) NOT NULL, ADD meeting_id VARCHAR(255) NOT NULL, ADD meeting_passcode VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE presentation ADD CONSTRAINT FK_9B66E893996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackathon (id)');
        $this->addSql('CREATE INDEX IDX_9B66E893996D90CF ON presentation (hackathon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presentation DROP FOREIGN KEY FK_9B66E893996D90CF');
        $this->addSql('DROP INDEX IDX_9B66E893996D90CF ON presentation');
        $this->addSql('ALTER TABLE presentation DROP hackathon_id, DROP time_end, DROP meeting_url, DROP meeting_id, DROP meeting_passcode');
    }
}
