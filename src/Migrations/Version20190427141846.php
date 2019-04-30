<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190427141846 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->
            getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE question (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
        question_text VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, 
        PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
        full_name VARCHAR(255) DEFAULT NULL, email VARCHAR(180) NOT NULL, gender VARCHAR(255) DEFAULT NULL, 
        date_of_birth DATETIME DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, 
        password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, 
        UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE 
        utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_answer (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
        question_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', question_answer_id CHAR(36) 
        NOT NULL COMMENT \'(DC2Type:uuid)\', user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
        created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET 
        utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_answers (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
        question_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', answer_text VARCHAR(255) NOT NULL, 
        created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET 
        utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->
            getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_answer');
        $this->addSql('DROP TABLE question_answers');
    }
}
