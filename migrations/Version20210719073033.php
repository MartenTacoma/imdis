<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210719073033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presentation ADD working_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE presentation ADD CONSTRAINT FK_9B66E8938856E875 FOREIGN KEY (working_group_id) REFERENCES working_group (id)');
        $this->addSql('CREATE INDEX IDX_9B66E8938856E875 ON presentation (working_group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presentation DROP FOREIGN KEY FK_9B66E8938856E875');
        $this->addSql('DROP INDEX IDX_9B66E8938856E875 ON presentation');
        $this->addSql('ALTER TABLE presentation DROP working_group_id');
    }
}
