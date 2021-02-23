<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223130718 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE user CHANGE country country VARCHAR(2) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495373C966 FOREIGN KEY (country) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495373C966 ON user (country)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495373C966');
        $this->addSql('DROP INDEX IDX_8D93D6495373C966 ON user');
        $this->addSql('ALTER TABLE user CHANGE country country VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
