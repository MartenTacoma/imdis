<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203075002 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poster ADD updated_at DATETIME DEFAULT NULL, ADD preview_name VARCHAR(255) DEFAULT NULL, ADD preview_original_name VARCHAR(255) DEFAULT NULL, ADD preview_mime_type VARCHAR(255) DEFAULT NULL, ADD preview_size INT DEFAULT NULL, ADD preview_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', DROP session_url, DROP preview_url');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poster ADD session_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD preview_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP updated_at, DROP preview_name, DROP preview_original_name, DROP preview_mime_type, DROP preview_size, DROP preview_dimensions');
    }
}
