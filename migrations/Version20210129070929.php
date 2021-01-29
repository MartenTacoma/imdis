<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210129070929 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('UPDATE imdis_abstract SET imdis_id = RIGHT(imdis_id, LENGTH(imdis_id)-2)');
        $this->addSql('ALTER TABLE imdis_abstract CHANGE imdis_id imdis_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE imdis_abstract CHANGE imdis_id imdis_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('UPDATE imdis_abstract SET imdis_id = CONCAT(theme_id, '-', imdis_id)');
    }
}
