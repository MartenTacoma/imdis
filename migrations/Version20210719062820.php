<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210719062820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE working_group (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, intro LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE working_group_event (working_group_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_643E76D68856E875 (working_group_id), INDEX IDX_643E76D671F7E88B (event_id), PRIMARY KEY(working_group_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE working_group_contact (id INT AUTO_INCREMENT NOT NULL, working_group_id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_23F5CC088856E875 (working_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE working_group_link (id INT AUTO_INCREMENT NOT NULL, working_group_id INT NOT NULL, url VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, INDEX IDX_A358E0C88856E875 (working_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE working_group_event ADD CONSTRAINT FK_643E76D68856E875 FOREIGN KEY (working_group_id) REFERENCES working_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE working_group_event ADD CONSTRAINT FK_643E76D671F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE working_group_contact ADD CONSTRAINT FK_23F5CC088856E875 FOREIGN KEY (working_group_id) REFERENCES working_group (id)');
        $this->addSql('ALTER TABLE working_group_link ADD CONSTRAINT FK_A358E0C88856E875 FOREIGN KEY (working_group_id) REFERENCES working_group (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE working_group_event DROP FOREIGN KEY FK_643E76D68856E875');
        $this->addSql('ALTER TABLE working_group_contact DROP FOREIGN KEY FK_23F5CC088856E875');
        $this->addSql('ALTER TABLE working_group_link DROP FOREIGN KEY FK_A358E0C88856E875');
        $this->addSql('DROP TABLE working_group');
        $this->addSql('DROP TABLE working_group_event');
        $this->addSql('DROP TABLE working_group_contact');
        $this->addSql('DROP TABLE working_group_link');
    }
}
