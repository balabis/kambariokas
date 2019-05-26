<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190526063201 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()
                ->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message_metadata (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
        message_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', participant_id CHAR(36) DEFAULT NULL 
        COMMENT \'(DC2Type:uuid)\', is_read TINYINT(1) NOT NULL, INDEX IDX_4632F005537A1329 (message_id),
         INDEX IDX_4632F0059D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE 
         utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
        title VARCHAR(255) NOT NULL, order_number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 
        COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', questionnaire_id 
        CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', question_text VARCHAR(255) NOT NULL, order_number INT NOT NULL, 
        created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B6F7494ECE07E8FF (questionnaire_id), 
        PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, PRIMARY 
KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire_score (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
        user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', sociability NUMERIC(3, 2) DEFAULT NULL, social_openness 
        NUMERIC(3, 2) DEFAULT NULL, social_flexibility NUMERIC(3, 2) DEFAULT NULL, cleanliness NUMERIC(3, 2) 
        DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', questionnaire_score_id 
        CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', full_name VARCHAR(255) DEFAULT NULL, email VARCHAR(180) 
        NOT NULL, username VARCHAR(255) NOT NULL, gender VARCHAR(255) DEFAULT NULL, date_of_birth DATETIME DEFAULT 
        NULL, city VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, profile_picture 
        VARCHAR(255) DEFAULT NULL, aboutme VARCHAR(255) DEFAULT NULL, city_part VARCHAR(255) DEFAULT NULL, budget 
        VARCHAR(255) DEFAULT NULL, occupation VARCHAR(255) DEFAULT NULL, hobbies VARCHAR(255) DEFAULT NULL, university 
        VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX 
        UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX 
        UNIQ_8D93D6498CD003DC (questionnaire_score_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET 
        utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_match (id INT AUTO_INCREMENT NOT NULL, first_user VARCHAR(36) NOT NULL, 
second_user VARCHAR(36) NOT NULL, coeficient DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET 
utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invite (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', sender_id 
        CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', receiver_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', 
        status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX 
        IDX_C7E210D7F624B39D (sender_id), INDEX IDX_C7E210D7CD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT 
        CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thread_metadata (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
        thread_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', participant_id CHAR(36) DEFAULT NULL COMMENT
         \'(DC2Type:uuid)\', is_deleted TINYINT(1) NOT NULL, last_participant_message_date DATETIME DEFAULT NULL,
          last_message_date DATETIME DEFAULT NULL, INDEX IDX_40A577C8E2904019 (thread_id), INDEX IDX_40A577C89D1C3019 
          (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE thread (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', created_by_id
         CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', subject VARCHAR(255) NOT NULL, created_at DATETIME NOT
          NULL, is_spam TINYINT(1) NOT NULL, INDEX IDX_31204C83B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT 
          CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', thread_id CHAR(36) 
        DEFAULT NULL COMMENT \'(DC2Type:uuid)\', sender_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', body 
        LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_B6BD307FE2904019 (thread_id), INDEX 
        IDX_B6BD307FF624B39D (sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci 
        ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_metadata ADD CONSTRAINT FK_4632F005537A1329 FOREIGN KEY (message_id) 
            REFERENCES message (id)');
        $this->addSql('ALTER TABLE message_metadata ADD CONSTRAINT FK_4632F0059D1C3019 FOREIGN KEY (participant_id)
            REFERENCES user (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ECE07E8FF FOREIGN KEY (questionnaire_id) 
            REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498CD003DC FOREIGN KEY (questionnaire_score_id)
             REFERENCES questionnaire_score (id)');
        $this->addSql('ALTER TABLE invite ADD CONSTRAINT FK_C7E210D7F624B39D FOREIGN KEY (sender_id) 
            REFERENCES user (id)');
        $this->addSql('ALTER TABLE invite ADD CONSTRAINT FK_C7E210D7CD53EDB6 FOREIGN KEY (receiver_id) 
            REFERENCES user (id)');
        $this->addSql('ALTER TABLE thread_metadata ADD CONSTRAINT FK_40A577C8E2904019 FOREIGN KEY (thread_id)
            REFERENCES thread (id)');
        $this->addSql('ALTER TABLE thread_metadata ADD CONSTRAINT FK_40A577C89D1C3019 FOREIGN KEY (participant_id)
            REFERENCES user (id)');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C83B03A8386 FOREIGN KEY (created_by_id)
            REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE2904019 FOREIGN KEY (thread_id) 
            REFERENCES thread (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) 
            REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()
                ->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ECE07E8FF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498CD003DC');
        $this->addSql('ALTER TABLE message_metadata DROP FOREIGN KEY FK_4632F0059D1C3019');
        $this->addSql('ALTER TABLE invite DROP FOREIGN KEY FK_C7E210D7F624B39D');
        $this->addSql('ALTER TABLE invite DROP FOREIGN KEY FK_C7E210D7CD53EDB6');
        $this->addSql('ALTER TABLE thread_metadata DROP FOREIGN KEY FK_40A577C89D1C3019');
        $this->addSql('ALTER TABLE thread DROP FOREIGN KEY FK_31204C83B03A8386');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE thread_metadata DROP FOREIGN KEY FK_40A577C8E2904019');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE2904019');
        $this->addSql('ALTER TABLE message_metadata DROP FOREIGN KEY FK_4632F005537A1329');
        $this->addSql('DROP TABLE message_metadata');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE questionnaire_score');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_match');
        $this->addSql('DROP TABLE invite');
        $this->addSql('DROP TABLE thread_metadata');
        $this->addSql('DROP TABLE thread');
        $this->addSql('DROP TABLE message');
    }
}
