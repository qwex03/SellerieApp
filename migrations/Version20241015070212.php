<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241015070212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, id_categorie_id INT NOT NULL, id_emplacement_id INT NOT NULL, id_etat_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_29A5EC279F34925F (id_categorie_id), INDEX IDX_29A5EC27F93F3757 (id_emplacement_id), INDEX IDX_29A5EC27D3C32F8F (id_etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC279F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27F93F3757 FOREIGN KEY (id_emplacement_id) REFERENCES emplacement (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27D3C32F8F FOREIGN KEY (id_etat_id) REFERENCES etat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC279F34925F');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27F93F3757');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27D3C32F8F');
        $this->addSql('DROP TABLE produit');
    }
}
