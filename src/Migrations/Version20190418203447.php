<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190418203447 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration 
        can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE question (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
                            question_id INT NOT NULL, question_text VARCHAR(255) NOT NULL, 
                            created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, 
                            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 
                            COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

        $this->addSql('CREATE TABLE provided_answer (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
                            provided_answer_id INT NOT NULL, provided_answer_text VARCHAR(255) NOT NULL, 
                            created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, 
                            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 
                            COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
                            full_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, 
                            date_of_birth DATETIME NOT NULL, city_code VARCHAR(255) NOT NULL, 
                            created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, 
                            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 
                            COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

        $this->addSql('CREATE TABLE user_answer (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', 
                            question_id INT NOT NULL, provided_answer_id INT NOT NULL, 
                            user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, 
                            updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 
                            COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE provided_answer');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_answer');
    }
}
