<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250304142559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_liste (utilisateur_id INT NOT NULL, liste_id INT NOT NULL, INDEX IDX_3A37722AFB88E14F (utilisateur_id), INDEX IDX_3A37722AE85441D8 (liste_id), PRIMARY KEY(utilisateur_id, liste_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_liste ADD CONSTRAINT FK_3A37722AFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_liste ADD CONSTRAINT FK_3A37722AE85441D8 FOREIGN KEY (liste_id) REFERENCES liste (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_liste DROP FOREIGN KEY FK_3A37722AFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_liste DROP FOREIGN KEY FK_3A37722AE85441D8');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_liste');
    }
}
