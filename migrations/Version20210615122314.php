<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210615122314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, alias VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hackathon (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hackathon_contact (id INT AUTO_INCREMENT NOT NULL, hackathon_id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_ACEE7DAF996D90CF (hackathon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hackathon_session (id INT AUTO_INCREMENT NOT NULL, hackathon_id INT NOT NULL, date DATE NOT NULL, time TIME NOT NULL, INDEX IDX_30C84E43996D90CF (hackathon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hackathon_contact ADD CONSTRAINT FK_ACEE7DAF996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackathon (id)');
        $this->addSql('ALTER TABLE hackathon_session ADD CONSTRAINT FK_30C84E43996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackathon (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hackathon_contact DROP FOREIGN KEY FK_ACEE7DAF996D90CF');
        $this->addSql('ALTER TABLE hackathon_session DROP FOREIGN KEY FK_30C84E43996D90CF');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE hackathon');
        $this->addSql('DROP TABLE hackathon_contact');
        $this->addSql('DROP TABLE hackathon_session');
    }
}
