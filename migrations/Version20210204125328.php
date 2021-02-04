<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210204125328 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE committee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE committee_person (id INT AUTO_INCREMENT NOT NULL, committee_id INT NOT NULL, name VARCHAR(255) NOT NULL, sort INT NOT NULL, INDEX IDX_42A260B9ED1A100B (committee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE committee_person ADD CONSTRAINT FK_42A260B9ED1A100B FOREIGN KEY (committee_id) REFERENCES committee (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE committee_person DROP FOREIGN KEY FK_42A260B9ED1A100B');
        $this->addSql('DROP TABLE committee');
        $this->addSql('DROP TABLE committee_person');
    }
}
