<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190516092108 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaire_score CHANGE sociability sociability NUMERIC(3, 2) DEFAULT NULL, CHANGE social_openness social_openness NUMERIC(3, 2) DEFAULT NULL, CHANGE social_flexibility social_flexibility NUMERIC(3, 2) DEFAULT NULL, CHANGE cleanliness cleanliness NUMERIC(3, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD questionnaire_score_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', CHANGE full_name full_name VARCHAR(255) DEFAULT NULL, CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATETIME DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE profile_picture profile_picture VARCHAR(255) DEFAULT NULL, CHANGE aboutme aboutme VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498CD003DC FOREIGN KEY (questionnaire_score_id) REFERENCES questionnaire_score (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6498CD003DC ON user (questionnaire_score_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questionnaire_score CHANGE sociability sociability NUMERIC(3, 2) DEFAULT \'NULL\', CHANGE social_openness social_openness NUMERIC(3, 2) DEFAULT \'NULL\', CHANGE social_flexibility social_flexibility NUMERIC(3, 2) DEFAULT \'NULL\', CHANGE cleanliness cleanliness NUMERIC(3, 2) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498CD003DC');
        $this->addSql('DROP INDEX UNIQ_8D93D6498CD003DC ON user');
        $this->addSql('ALTER TABLE user DROP questionnaire_score_id, CHANGE full_name full_name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE gender gender VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE date_of_birth date_of_birth DATETIME DEFAULT \'NULL\', CHANGE city city VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE profile_picture profile_picture VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE aboutme aboutme VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
