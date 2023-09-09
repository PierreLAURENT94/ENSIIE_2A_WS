<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230908135252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE billet_classe_dispo (id INT AUTO_INCREMENT NOT NULL, premiere INT NOT NULL, premium INT NOT NULL, standard INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, gare VARCHAR(255) NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE train (id INT AUTO_INCREMENT NOT NULL, depart_id INT NOT NULL, arrivee_id INT NOT NULL, billets_id INT NOT NULL, UNIQUE INDEX UNIQ_5C66E4A3AE02FE4B (depart_id), UNIQUE INDEX UNIQ_5C66E4A3EAF07E42 (arrivee_id), UNIQUE INDEX UNIQ_5C66E4A3B9EBD317 (billets_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE train ADD CONSTRAINT FK_5C66E4A3AE02FE4B FOREIGN KEY (depart_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE train ADD CONSTRAINT FK_5C66E4A3EAF07E42 FOREIGN KEY (arrivee_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE train ADD CONSTRAINT FK_5C66E4A3B9EBD317 FOREIGN KEY (billets_id) REFERENCES billet_classe_dispo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE train DROP FOREIGN KEY FK_5C66E4A3AE02FE4B');
        $this->addSql('ALTER TABLE train DROP FOREIGN KEY FK_5C66E4A3EAF07E42');
        $this->addSql('ALTER TABLE train DROP FOREIGN KEY FK_5C66E4A3B9EBD317');
        $this->addSql('DROP TABLE billet_classe_dispo');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE train');
    }
}
