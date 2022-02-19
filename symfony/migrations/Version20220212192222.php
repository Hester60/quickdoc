<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Enum\HexaColor;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220212192222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute 2 tags par défaut';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO tag (label, color) VALUES ('Fonctionnel','" . HexaColor::GREEN->value . "' )");
        $this->addSql("INSERT INTO tag (label, color) VALUES ('Technique','" . HexaColor::RED->value . "' )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM tag WHERE label = 'Technique'");
        $this->addSql("DELETE FROM tag WHERE label = 'Fonctionnel'");
    }
}
