<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241121222824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reparations DROP FOREIGN KEY FK_953FFFD3B4C15F44');
        $this->addSql('DROP INDEX IDX_953FFFD3B4C15F44 ON reparations');
        $this->addSql('ALTER TABLE reparations CHANGE réparateur_id reparateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reparations ADD CONSTRAINT FK_953FFFD34E2493C5 FOREIGN KEY (reparateur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_953FFFD34E2493C5 ON reparations (reparateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reparations DROP FOREIGN KEY FK_953FFFD34E2493C5');
        $this->addSql('DROP INDEX IDX_953FFFD34E2493C5 ON reparations');
        $this->addSql('ALTER TABLE reparations CHANGE reparateur_id réparateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reparations ADD CONSTRAINT FK_953FFFD3B4C15F44 FOREIGN KEY (réparateur_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_953FFFD3B4C15F44 ON reparations (réparateur_id)');
    }
}
