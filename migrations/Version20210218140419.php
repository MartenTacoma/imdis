<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210218140419 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_poster (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, poster_id INT NOT NULL, INDEX IDX_482317CFA76ED395 (user_id), INDEX IDX_482317CF5BB66C05 (poster_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_presentation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, presentation_id INT NOT NULL, INDEX IDX_1BAA9491A76ED395 (user_id), INDEX IDX_1BAA9491AB627E8B (presentation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_poster ADD CONSTRAINT FK_482317CFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_poster ADD CONSTRAINT FK_482317CF5BB66C05 FOREIGN KEY (poster_id) REFERENCES poster (id)');
        $this->addSql('ALTER TABLE user_presentation ADD CONSTRAINT FK_1BAA9491A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_presentation ADD CONSTRAINT FK_1BAA9491AB627E8B FOREIGN KEY (presentation_id) REFERENCES presentation (id)');
        $this->addSql('ALTER TABLE presentation_type ADD consent TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_poster');
        $this->addSql('DROP TABLE user_presentation');
        $this->addSql('ALTER TABLE presentation_type DROP consent');
    }
}
