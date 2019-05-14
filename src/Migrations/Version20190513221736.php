<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190513221736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()
                ->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE questionnaire_score CHANGE sociability sociability NUMERIC(3, 2) DEFAULT NULL, 
            CHANGE social_openness social_openness NUMERIC(3, 2) DEFAULT NULL, CHANGE social_flexibility 
            social_flexibility NUMERIC(3, 2) DEFAULT NULL, CHANGE cleanliness cleanliness NUMERIC(3, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE full_name full_name VARCHAR(255) DEFAULT NULL, 
            CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATETIME DEFAULT NULL, 
            CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE profile_picture 
            profile_picture VARCHAR(255) DEFAULT NULL, CHANGE aboutme aboutme VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_match ADD user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user_match ADD CONSTRAINT FK_98993E5DA76ED395 FOREIGN KEY (user_id) 
            REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_98993E5DA76ED395 ON user_match (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()
                ->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE questionnaire_score CHANGE sociability sociability NUMERIC(3, 2) DEFAULT \'NULL\', 
            CHANGE social_openness social_openness NUMERIC(3, 2) DEFAULT \'NULL\', CHANGE social_flexibility 
            social_flexibility NUMERIC(3, 2) DEFAULT \'NULL\', CHANGE cleanliness cleanliness 
            NUMERIC(3, 2) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE full_name full_name VARCHAR(255) DEFAULT \'NULL\' 
        COLLATE utf8mb4_unicode_ci, CHANGE gender gender VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, 
        CHANGE date_of_birth date_of_birth DATETIME DEFAULT \'NULL\', CHANGE city city VARCHAR(255) DEFAULT \'NULL\' 
        COLLATE utf8mb4_unicode_ci, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE profile_picture 
        profile_picture VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE aboutme aboutme VARCHAR(255) 
        DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user_match DROP FOREIGN KEY FK_98993E5DA76ED395');
        $this->addSql('DROP INDEX IDX_98993E5DA76ED395 ON user_match');
        $this->addSql('ALTER TABLE user_match DROP user_id');
    }
}
