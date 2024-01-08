<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231126154341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE paniers');
        $this->addSql('ALTER TABLE chat DROP id_user');
        $this->addSql('ALTER TABLE commandes DROP id_user');
        $this->addSql('ALTER TABLE essai_virtuel DROP id_user');
        $this->addSql('ALTER TABLE produits ADD categories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8CA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_BE2DDF8CA21214B7 ON produits (categories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paniers (id INT AUTO_INCREMENT NOT NULL, quantite INT NOT NULL, prix INT NOT NULL, montant_total INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE chat ADD id_user INT NOT NULL');
        $this->addSql('ALTER TABLE commandes ADD id_user INT NOT NULL');
        $this->addSql('ALTER TABLE essai_virtuel ADD id_user INT NOT NULL');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8CA21214B7');
        $this->addSql('DROP INDEX IDX_BE2DDF8CA21214B7 ON produits');
        $this->addSql('ALTER TABLE produits DROP categories_id');
    }
}
