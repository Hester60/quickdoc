<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Enum\HexaColor;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220217210803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO tag (label, color) VALUES ('Todolist','" . HexaColor::PURPLE->value . "' )");
        $this->addSql("INSERT INTO tag (label, color) VALUES ('Note','" . HexaColor::GREEN->value . "' )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM tag WHERE label = 'Note'");
        $this->addSql("DELETE FROM tag WHERE label = 'Todolist'");
    }
}
