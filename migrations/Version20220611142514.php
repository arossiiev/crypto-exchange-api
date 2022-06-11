<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220611142514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO asset_pair (base, quote) VALUES('BTC', 'EUR');");
        $this->addSql("INSERT INTO asset_pair (base, quote) VALUES('BTC', 'USD');");
        $this->addSql("INSERT INTO asset_pair (base, quote) VALUES('BTC', 'ETH');");
        $this->addSql("INSERT INTO asset_pair (base, quote) VALUES('ETH', 'USD');");
        $this->addSql("INSERT INTO asset_pair (base, quote) VALUES('ETH', 'EUR');");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("TRUNCATE TABLE asset_pair");
    }
}
