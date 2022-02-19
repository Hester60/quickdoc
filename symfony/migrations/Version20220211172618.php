<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220211172618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création d\'un utilisateur de base';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $email = 'default@quickdoc.com';
        $hashedPassword = '$2y$13$eB8wzXRmDY0Ray6ptS1jPuslazskDR5/pWT2FLJKNgnnWRdlmdKxq';
        $roles = json_encode([]);
        $this->addSql("INSERT INTO user (email, roles, password) VALUES ('" . $email . "', '" . $roles . "', '" . $hashedPassword . "')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM user WHERE email = "default@quickdoc.fr"');
    }
}
