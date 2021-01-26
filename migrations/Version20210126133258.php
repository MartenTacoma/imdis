<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126133258 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE committee_person DROP FOREIGN KEY FK_42A260B9ED1A100B');
        $this->addSql('DROP TABLE committee');
        $this->addSql('DROP TABLE committee_person');
        
        $this->addSql('ALTER TABLE abstract_person DROP FOREIGN KEY FK_E4CB3355217BBB47');
        $this->addSql('DROP INDEX IDX_E4CB3355217BBB47 ON abstract_person');
        $this->addSql('ALTER TABLE abstract_person ADD name VARCHAR(255) NOT NULL');
        $this->addSql('UPDATE abstract_person t INNER JOIN person p ON p.id=t.person_id SET t.name = p.name');
        $this->addSql('ALTER TABLE abstract_person DROP person_id');
        
        $this->addSql('ALTER TABLE presentation_person DROP FOREIGN KEY FK_95EB27F3217BBB47');
        $this->addSql('DROP INDEX IDX_95EB27F3217BBB47 ON presentation_person');
        $this->addSql('ALTER TABLE presentation_person ADD name VARCHAR(255) NOT NULL');
        $this->addSql('UPDATE presentation_person t INNER JOIN person p ON p.id=t.person_id SET t.name = p.name');
        $this->addSql('ALTER TABLE presentation_person DROP person_id');
        
        $this->addSql('ALTER TABLE session_chair DROP FOREIGN KEY FK_7E7EFC53217BBB47');
        $this->addSql('DROP INDEX IDX_7E7EFC53217BBB47 ON session_chair');
        $this->addSql('ALTER TABLE session_chair ADD name VARCHAR(255) NOT NULL');
        $this->addSql('UPDATE session_chair t INNER JOIN person p ON p.id=t.person_id SET t.name = p.name');
        $this->addSql('ALTER TABLE session_chair DROP person_id');
        
        $this->addSql('DROP TABLE person');
        
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE committee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE committee_person (id INT AUTO_INCREMENT NOT NULL, committee_id INT NOT NULL, person_id INT NOT NULL, sort INT NOT NULL, INDEX IDX_42A260B9217BBB47 (person_id), INDEX IDX_42A260B9ED1A100B (committee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE committee_person ADD CONSTRAINT FK_42A260B9217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE committee_person ADD CONSTRAINT FK_42A260B9ED1A100B FOREIGN KEY (committee_id) REFERENCES committee (id)');
        $this->addSql('ALTER TABLE abstract_person ADD person_id INT NOT NULL, DROP name');
        $this->addSql('ALTER TABLE abstract_person ADD CONSTRAINT FK_E4CB3355217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_E4CB3355217BBB47 ON abstract_person (person_id)');
        $this->addSql('ALTER TABLE presentation_person ADD person_id INT NOT NULL, DROP name');
        $this->addSql('ALTER TABLE presentation_person ADD CONSTRAINT FK_95EB27F3217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_95EB27F3217BBB47 ON presentation_person (person_id)');
        $this->addSql('ALTER TABLE session_chair ADD person_id INT NOT NULL, DROP name');
        $this->addSql('ALTER TABLE session_chair ADD CONSTRAINT FK_7E7EFC53217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_7E7EFC53217BBB47 ON session_chair (person_id)');
    }
}
