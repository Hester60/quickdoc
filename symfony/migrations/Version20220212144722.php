<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220212144722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute le main_parent à la table page';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page ADD main_parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62052CC6DD2 FOREIGN KEY (main_parent_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_140AB62052CC6DD2 ON page (main_parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62052CC6DD2');
        $this->addSql('DROP INDEX IDX_140AB62052CC6DD2 ON page');
        $this->addSql('ALTER TABLE page DROP main_parent_id');
    }
}
