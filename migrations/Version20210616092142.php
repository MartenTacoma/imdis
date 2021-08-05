<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210616092142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE program_block_event (program_block_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_30A5812968D87E39 (program_block_id), INDEX IDX_30A5812971F7E88B (event_id), PRIMARY KEY(program_block_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE program_block_event ADD CONSTRAINT FK_30A5812968D87E39 FOREIGN KEY (program_block_id) REFERENCES program_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_block_event ADD CONSTRAINT FK_30A5812971F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE program_block_event');
    }
}
