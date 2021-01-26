<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126092724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abstract_person (id INT AUTO_INCREMENT NOT NULL, abstract_id INT NOT NULL, person_id INT NOT NULL, sort INT NOT NULL, is_presenter TINYINT(1) NOT NULL, INDEX IDX_E4CB3355D56B77AA (abstract_id), INDEX IDX_E4CB3355217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE committee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE committee_person (id INT AUTO_INCREMENT NOT NULL, committee_id INT NOT NULL, person_id INT NOT NULL, sort INT NOT NULL, INDEX IDX_42A260B9ED1A100B (committee_id), INDEX IDX_42A260B9217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE imdis_abstract (id INT AUTO_INCREMENT NOT NULL, theme_id INT NOT NULL, title VARCHAR(255) NOT NULL, abstract LONGTEXT DEFAULT NULL, imdis_id VARCHAR(255) NOT NULL, INDEX IDX_1AA07CB059027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, affiliation VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, orcid VARCHAR(255) DEFAULT NULL, show_in_list TINYINT(1) DEFAULT \'0\' NOT NULL, show_mail_in_list TINYINT(1) DEFAULT \'0\' NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poster (id INT AUTO_INCREMENT NOT NULL, poster_session_id INT NOT NULL, abstract_id INT NOT NULL, video_url VARCHAR(255) DEFAULT NULL, comment_url VARCHAR(255) DEFAULT NULL, download_url VARCHAR(255) DEFAULT NULL, session_url VARCHAR(255) DEFAULT NULL, preview_url VARCHAR(255) NOT NULL, INDEX IDX_2D710CF24C4C8295 (poster_session_id), UNIQUE INDEX UNIQ_2D710CF2D56B77AA (abstract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poster_session (id INT AUTO_INCREMENT NOT NULL, time_start TIME NOT NULL, time_end TIME NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poster_session_theme (poster_session_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_377314A4C4C8295 (poster_session_id), INDEX IDX_377314A59027487 (theme_id), PRIMARY KEY(poster_session_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presentation (id INT AUTO_INCREMENT NOT NULL, program_session_id INT NOT NULL, abstract_id INT DEFAULT NULL, type_id INT NOT NULL, poster_session_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, time_start TIME NOT NULL, video_url VARCHAR(255) DEFAULT NULL, INDEX IDX_9B66E8937705116B (program_session_id), UNIQUE INDEX UNIQ_9B66E893D56B77AA (abstract_id), INDEX IDX_9B66E893C54C8C93 (type_id), UNIQUE INDEX UNIQ_9B66E8934C4C8295 (poster_session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presentation_person (id INT AUTO_INCREMENT NOT NULL, presentation_id INT NOT NULL, person_id INT NOT NULL, sort INT NOT NULL, presenter TINYINT(1) NOT NULL, INDEX IDX_95EB27F3AB627E8B (presentation_id), INDEX IDX_95EB27F3217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presentation_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, fields_required LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', fields_not_allowed LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_block (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, time_start TIME NOT NULL, time_end TIME NOT NULL, session_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_session (id INT AUTO_INCREMENT NOT NULL, block_id INT NOT NULL, theme_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, time_start TIME NOT NULL, INDEX IDX_5BAE2D00E9ED820C (block_id), INDEX IDX_5BAE2D0059027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_chair (id INT AUTO_INCREMENT NOT NULL, session_id INT NOT NULL, person_id INT NOT NULL, sort INT NOT NULL, INDEX IDX_7E7EFC53613FECDF (session_id), INDEX IDX_7E7EFC53217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, tagline VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, registration_time DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abstract_person ADD CONSTRAINT FK_E4CB3355D56B77AA FOREIGN KEY (abstract_id) REFERENCES imdis_abstract (id)');
        $this->addSql('ALTER TABLE abstract_person ADD CONSTRAINT FK_E4CB3355217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE committee_person ADD CONSTRAINT FK_42A260B9ED1A100B FOREIGN KEY (committee_id) REFERENCES committee (id)');
        $this->addSql('ALTER TABLE committee_person ADD CONSTRAINT FK_42A260B9217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE imdis_abstract ADD CONSTRAINT FK_1AA07CB059027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE poster ADD CONSTRAINT FK_2D710CF24C4C8295 FOREIGN KEY (poster_session_id) REFERENCES poster_session (id)');
        $this->addSql('ALTER TABLE poster ADD CONSTRAINT FK_2D710CF2D56B77AA FOREIGN KEY (abstract_id) REFERENCES imdis_abstract (id)');
        $this->addSql('ALTER TABLE poster_session_theme ADD CONSTRAINT FK_377314A4C4C8295 FOREIGN KEY (poster_session_id) REFERENCES poster_session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE poster_session_theme ADD CONSTRAINT FK_377314A59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE presentation ADD CONSTRAINT FK_9B66E8937705116B FOREIGN KEY (program_session_id) REFERENCES program_session (id)');
        $this->addSql('ALTER TABLE presentation ADD CONSTRAINT FK_9B66E893D56B77AA FOREIGN KEY (abstract_id) REFERENCES imdis_abstract (id)');
        $this->addSql('ALTER TABLE presentation ADD CONSTRAINT FK_9B66E893C54C8C93 FOREIGN KEY (type_id) REFERENCES presentation_type (id)');
        $this->addSql('ALTER TABLE presentation ADD CONSTRAINT FK_9B66E8934C4C8295 FOREIGN KEY (poster_session_id) REFERENCES poster_session (id)');
        $this->addSql('ALTER TABLE presentation_person ADD CONSTRAINT FK_95EB27F3AB627E8B FOREIGN KEY (presentation_id) REFERENCES presentation (id)');
        $this->addSql('ALTER TABLE presentation_person ADD CONSTRAINT FK_95EB27F3217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE program_session ADD CONSTRAINT FK_5BAE2D00E9ED820C FOREIGN KEY (block_id) REFERENCES program_block (id)');
        $this->addSql('ALTER TABLE program_session ADD CONSTRAINT FK_5BAE2D0059027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE session_chair ADD CONSTRAINT FK_7E7EFC53613FECDF FOREIGN KEY (session_id) REFERENCES program_session (id)');
        $this->addSql('ALTER TABLE session_chair ADD CONSTRAINT FK_7E7EFC53217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE committee_person DROP FOREIGN KEY FK_42A260B9ED1A100B');
        $this->addSql('ALTER TABLE abstract_person DROP FOREIGN KEY FK_E4CB3355D56B77AA');
        $this->addSql('ALTER TABLE poster DROP FOREIGN KEY FK_2D710CF2D56B77AA');
        $this->addSql('ALTER TABLE presentation DROP FOREIGN KEY FK_9B66E893D56B77AA');
        $this->addSql('ALTER TABLE abstract_person DROP FOREIGN KEY FK_E4CB3355217BBB47');
        $this->addSql('ALTER TABLE committee_person DROP FOREIGN KEY FK_42A260B9217BBB47');
        $this->addSql('ALTER TABLE presentation_person DROP FOREIGN KEY FK_95EB27F3217BBB47');
        $this->addSql('ALTER TABLE session_chair DROP FOREIGN KEY FK_7E7EFC53217BBB47');
        $this->addSql('ALTER TABLE poster DROP FOREIGN KEY FK_2D710CF24C4C8295');
        $this->addSql('ALTER TABLE poster_session_theme DROP FOREIGN KEY FK_377314A4C4C8295');
        $this->addSql('ALTER TABLE presentation DROP FOREIGN KEY FK_9B66E8934C4C8295');
        $this->addSql('ALTER TABLE presentation_person DROP FOREIGN KEY FK_95EB27F3AB627E8B');
        $this->addSql('ALTER TABLE presentation DROP FOREIGN KEY FK_9B66E893C54C8C93');
        $this->addSql('ALTER TABLE program_session DROP FOREIGN KEY FK_5BAE2D00E9ED820C');
        $this->addSql('ALTER TABLE presentation DROP FOREIGN KEY FK_9B66E8937705116B');
        $this->addSql('ALTER TABLE session_chair DROP FOREIGN KEY FK_7E7EFC53613FECDF');
        $this->addSql('ALTER TABLE imdis_abstract DROP FOREIGN KEY FK_1AA07CB059027487');
        $this->addSql('ALTER TABLE poster_session_theme DROP FOREIGN KEY FK_377314A59027487');
        $this->addSql('ALTER TABLE program_session DROP FOREIGN KEY FK_5BAE2D0059027487');
        $this->addSql('DROP TABLE abstract_person');
        $this->addSql('DROP TABLE committee');
        $this->addSql('DROP TABLE committee_person');
        $this->addSql('DROP TABLE imdis_abstract');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE poster');
        $this->addSql('DROP TABLE poster_session');
        $this->addSql('DROP TABLE poster_session_theme');
        $this->addSql('DROP TABLE presentation');
        $this->addSql('DROP TABLE presentation_person');
        $this->addSql('DROP TABLE presentation_type');
        $this->addSql('DROP TABLE program_block');
        $this->addSql('DROP TABLE program_session');
        $this->addSql('DROP TABLE session_chair');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE user');
    }
}
