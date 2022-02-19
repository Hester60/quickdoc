<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220213160613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_history (id INT AUTO_INCREMENT NOT NULL, updated_by_id INT DEFAULT NULL, page_id INT NOT NULL, name VARCHAR(255) NOT NULL, body LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, version INT NOT NULL, INDEX IDX_DDDA9BDE896DBBDE (updated_by_id), INDEX IDX_DDDA9BDEC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_history ADD CONSTRAINT FK_DDDA9BDE896DBBDE FOREIGN KEY (updated_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE page_history ADD CONSTRAINT FK_DDDA9BDEC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE page_history');
    }
}
