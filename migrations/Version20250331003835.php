<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331003835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE liste ADD CONSTRAINT FK_FCF22AF4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FCF22AF4A76ED395 ON liste (user_id)');
        $this->addSql('ALTER TABLE user CHANGE image image VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste DROP FOREIGN KEY FK_FCF22AF4A76ED395');
        $this->addSql('DROP INDEX IDX_FCF22AF4A76ED395 ON liste');
        $this->addSql('ALTER TABLE liste DROP user_id');
        $this->addSql('ALTER TABLE user CHANGE image image VARCHAR(100) DEFAULT \'default-user-icon.svg\' NOT NULL');
    }
}
