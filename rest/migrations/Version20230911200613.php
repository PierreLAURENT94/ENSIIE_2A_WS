<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230911200613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE train (id INT AUTO_INCREMENT NOT NULL, departure_station_id INT NOT NULL, arrival_station_id INT NOT NULL, departure_date_time DATETIME NOT NULL, arrival_date_time DATETIME NOT NULL, seats_available_business INT NOT NULL, price_business DOUBLE PRECISION NOT NULL, seats_available_first INT NOT NULL, price_first DOUBLE PRECISION NOT NULL, seats_available_standard INT NOT NULL, price_standard DOUBLE PRECISION NOT NULL, INDEX IDX_5C66E4A3FF134AA1 (departure_station_id), INDEX IDX_5C66E4A3766102BE (arrival_station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE train ADD CONSTRAINT FK_5C66E4A3FF134AA1 FOREIGN KEY (departure_station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE train ADD CONSTRAINT FK_5C66E4A3766102BE FOREIGN KEY (arrival_station_id) REFERENCES station (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE train DROP FOREIGN KEY FK_5C66E4A3FF134AA1');
        $this->addSql('ALTER TABLE train DROP FOREIGN KEY FK_5C66E4A3766102BE');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE train');
    }
}
