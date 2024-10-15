<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241015114116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique CHANGE date_pret date_pret DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE date_retour date_retour DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique CHANGE date_pret date_pret DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE date_retour date_retour DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
