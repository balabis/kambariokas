<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190507185819 extends AbstractMigration
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

        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, 
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire_score (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
            user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', sociability NUMERIC(3, 2) DEFAULT NULL, 
            social_openness NUMERIC(3, 2) DEFAULT NULL, social_flexibility NUMERIC(3, 2) DEFAULT NULL, 
            cleanliness NUMERIC(3, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 
            COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE question_answers');
        $this->addSql('DROP TABLE user_answer');
        $this->addSql('ALTER TABLE questionnaire ADD order_number INT NOT NULL');
        $this->addSql('ALTER TABLE question ADD order_number INT NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ECE07E8FF 
            FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494ECE07E8FF ON question (questionnaire_id)');
        $this->addSql('ALTER TABLE user CHANGE full_name full_name VARCHAR(255) DEFAULT NULL, 
            CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATETIME DEFAULT NULL,
            CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()
                ->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('CREATE TABLE question_answers (id CHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci 
            COMMENT \'(DC2Type:uuid)\', question_id CHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci 
            COMMENT \'(DC2Type:uuid)\', answer_text VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, 
            created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5E0C131B1E27F6BF (question_id), 
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_answer (id CHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci 
            COMMENT \'(DC2Type:uuid)\', question_id CHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci 
            COMMENT \'(DC2Type:uuid)\', question_answer_id CHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci 
            COMMENT \'(DC2Type:uuid)\', user_id CHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci 
            COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, 
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE question_answers ADD CONSTRAINT FK_5E0C131B1E27F6BF 
            FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE questionnaire_score');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ECE07E8FF');
        $this->addSql('DROP INDEX IDX_B6F7494ECE07E8FF ON question');
        $this->addSql('ALTER TABLE question DROP order_number');
        $this->addSql('ALTER TABLE questionnaire DROP order_number');
        $this->addSql('ALTER TABLE user CHANGE full_name full_name VARCHAR(255) DEFAULT \'NULL\' 
            COLLATE utf8mb4_unicode_ci, CHANGE gender gender VARCHAR(255) DEFAULT \'NULL\' 
            COLLATE utf8mb4_unicode_ci, CHANGE date_of_birth date_of_birth DATETIME DEFAULT \'NULL\', 
            CHANGE city city VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, 
            CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
