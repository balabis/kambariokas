<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190429100222 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName()
            !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE questionnaire (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
         title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) 
         DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question ADD questionnaire_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user CHANGE full_name full_name VARCHAR(255) DEFAULT NULL,
        CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATETIME DEFAULT NULL,
        CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE question_answers ADD CONSTRAINT FK_5E0C131B1E27F6BF 
        FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_5E0C131B1E27F6BF ON question_answers (question_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName()
            !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('ALTER TABLE question DROP questionnaire_id');
        $this->addSql('ALTER TABLE question_answers DROP FOREIGN KEY FK_5E0C131B1E27F6BF');
        $this->addSql('DROP INDEX IDX_5E0C131B1E27F6BF ON question_answers');
        $this->addSql('ALTER TABLE user CHANGE full_name full_name VARCHAR(255) DEFAULT \'NULL\' COLLATE 
        utf8mb4_unicode_ci, CHANGE gender gender VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci,
         CHANGE date_of_birth date_of_birth DATETIME DEFAULT \'NULL\', CHANGE city city VARCHAR(255) DEFAULT 
         \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
