<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220212132303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout des paramètres de page';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_parameter (id INT AUTO_INCREMENT NOT NULL, page_id INT NOT NULL, hide_empty_parent TINYINT(1) NOT NULL, hide_empty_children TINYINT(1) NOT NULL, open_parent_by_default TINYINT(1) NOT NULL, open_children_by_default TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_11792EDFC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_parameter ADD CONSTRAINT FK_11792EDFC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE page_parameter');
    }
}
