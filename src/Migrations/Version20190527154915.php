<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190527154915 extends AbstractMigration
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

        $this->addSql('ALTER TABLE message_metadata CHANGE message_id message_id CHAR(36) DEFAULT NULL 
            COMMENT \'(DC2Type:uuid)\', CHANGE participant_id participant_id CHAR(36) DEFAULT 
            NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE questionnaire_score CHANGE sociability sociability NUMERIC(3, 2) DEFAULT NULL, 
            CHANGE social_openness social_openness NUMERIC(3, 2) DEFAULT NULL, CHANGE social_flexibility 
            social_flexibility NUMERIC(3, 2) DEFAULT NULL, CHANGE cleanliness cleanliness NUMERIC(3, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD status VARCHAR(255) NOT NULL, CHANGE questionnaire_score_id 
            questionnaire_score_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', CHANGE full_name 
            full_name VARCHAR(255) DEFAULT 
            NULL, CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATETIME DEFAULT 
            NULL, CHANGE city city VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE profile_picture 
            profile_picture VARCHAR(255) DEFAULT NULL, CHANGE aboutme aboutme VARCHAR(255) DEFAULT NULL, CHANGE 
            city_part city_part VARCHAR(255) DEFAULT NULL, CHANGE budget budget VARCHAR(255) DEFAULT NULL, 
            CHANGE occupation occupation VARCHAR(255) DEFAULT NULL, CHANGE hobbies hobbies VARCHAR(255) 
            DEFAULT NULL, CHANGE university university VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE invite CHANGE sender_id sender_id CHAR(36) DEFAULT NULL COMMENT 
        \'(DC2Type:uuid)\', CHANGE receiver_id receiver_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE thread_metadata CHANGE thread_id thread_id CHAR(36) DEFAULT NULL 
        COMMENT \'(DC2Type:uuid)\', CHANGE participant_id participant_id CHAR(36) DEFAULT NULL COMMENT 
        \'(DC2Type:uuid)\', CHANGE last_participant_message_date last_participant_message_date DATETIME DEFAULT NULL, 
        CHANGE last_message_date last_message_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE thread CHANGE created_by_id created_by_id CHAR(36) DEFAULT NULL 
        COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE message CHANGE thread_id thread_id CHAR(36) DEFAULT NULL COMMENT 
        \'(DC2Type:uuid)\', CHANGE sender_id sender_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()
                ->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE invite CHANGE sender_id sender_id CHAR(36) DEFAULT \'NULL\' COLLATE 
        utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\', CHANGE receiver_id receiver_id CHAR(36) DEFAULT \'NULL\' 
        COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE message CHANGE thread_id thread_id CHAR(36) DEFAULT \'NULL\' COLLATE 
        utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\', CHANGE sender_id sender_id CHAR(36) DEFAULT \'NULL\' 
        COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE message_metadata CHANGE message_id message_id CHAR(36) DEFAULT 
        \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\', CHANGE participant_id participant_id 
        CHAR(36) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE questionnaire_score CHANGE sociability sociability NUMERIC(3, 2) 
        DEFAULT \'NULL\', CHANGE social_openness social_openness NUMERIC(3, 2) DEFAULT \'NULL\', 
        CHANGE social_flexibility social_flexibility NUMERIC(3, 2) DEFAULT \'NULL\', CHANGE cleanliness 
        cleanliness NUMERIC(3, 2) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE thread CHANGE created_by_id created_by_id CHAR(36) DEFAULT 
        \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE thread_metadata CHANGE thread_id thread_id CHAR(36) DEFAULT 
        \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\', CHANGE participant_id 
        participant_id CHAR(36) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\', 
        CHANGE last_participant_message_date last_participant_message_date DATETIME DEFAULT \'NULL\', 
        CHANGE last_message_date last_message_date DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user DROP status, CHANGE questionnaire_score_id 
        questionnaire_score_id CHAR(36) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci COMMENT 
        \'(DC2Type:uuid)\', CHANGE full_name full_name VARCHAR(255) DEFAULT \'NULL\' COLLATE 
        utf8mb4_unicode_ci, CHANGE gender gender VARCHAR(255) DEFAULT \'NULL\' COLLATE 
        utf8mb4_unicode_ci, CHANGE date_of_birth date_of_birth DATETIME DEFAULT \'NULL\', 
        CHANGE city city VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE 
        roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE profile_picture profile_picture
         VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE aboutme aboutme VARCHAR(255)
          DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE city_part city_part VARCHAR(255) DEFAULT 
          \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE budget budget VARCHAR(255) DEFAULT \'NULL\' 
          COLLATE utf8mb4_unicode_ci, CHANGE occupation occupation VARCHAR(255) DEFAULT \'NULL\' COLLATE 
          utf8mb4_unicode_ci, CHANGE hobbies hobbies VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, 
          CHANGE university university VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
