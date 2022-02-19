<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220212192029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute la relation entre la table page et tag';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page ADD tag_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('CREATE INDEX IDX_140AB620BAD26311 ON page (tag_id)');
        $this->addSql('ALTER TABLE tag CHANGE color color VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620BAD26311');
        $this->addSql('DROP INDEX IDX_140AB620BAD26311 ON page');
        $this->addSql('ALTER TABLE page DROP tag_id');
        $this->addSql('ALTER TABLE tag CHANGE color color VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
