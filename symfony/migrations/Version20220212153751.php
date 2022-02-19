<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220212153751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute le showHierarchy à la table page_parameter, supprime les anciens paramètres';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_parameter ADD show_hierarchy TINYINT(1) NOT NULL, ADD open_hierarchy_by_default TINYINT(1) NOT NULL, DROP hide_empty_parent, DROP hide_empty_children, DROP open_parent_by_default, DROP open_children_by_default');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_parameter ADD hide_empty_parent TINYINT(1) NOT NULL, ADD hide_empty_children TINYINT(1) NOT NULL, ADD open_parent_by_default TINYINT(1) NOT NULL, ADD open_children_by_default TINYINT(1) NOT NULL, DROP show_hierarchy, DROP open_hierarchy_by_default');
    }
}
