<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230910170233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE train (id INT AUTO_INCREMENT NOT NULL, departure_station VARCHAR(255) NOT NULL, departure_date_time DATETIME NOT NULL, arrival_station VARCHAR(255) NOT NULL, arrival_date_time DATETIME NOT NULL, seats_available_business INT NOT NULL, price_business DOUBLE PRECISION NOT NULL, seats_available_first INT NOT NULL, price_first DOUBLE PRECISION NOT NULL, seats_available_standard INT NOT NULL, price_standard DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE train');
    }
}
