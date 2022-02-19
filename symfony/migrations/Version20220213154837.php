<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220213154837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("UPDATE user SET first_name = 'Thomas' WHERE email = 'default@quickdoc.com'");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("UPDATE user SET first_name = null WHERE email = 'default@quickdoc.com'");
    }
}
