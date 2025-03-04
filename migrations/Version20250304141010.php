<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250304141010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_article DROP FOREIGN KEY FK_B30096377294869C');
        $this->addSql('ALTER TABLE liste_article DROP FOREIGN KEY FK_B3009637E85441D8');
        $this->addSql('DROP INDEX IDX_B3009637E85441D8 ON liste_article');
        $this->addSql('DROP INDEX IDX_B30096377294869C ON liste_article');
        $this->addSql('ALTER TABLE liste_article ADD id INT AUTO_INCREMENT NOT NULL, ADD articles_id INT NOT NULL, ADD listes_id INT NOT NULL, ADD est_achete TINYINT(1) NOT NULL, ADD quantite INT NOT NULL, DROP liste_id, DROP article_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE liste_article ADD CONSTRAINT FK_B30096371EBAF6CC FOREIGN KEY (articles_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE liste_article ADD CONSTRAINT FK_B30096376F91B382 FOREIGN KEY (listes_id) REFERENCES liste (id)');
        $this->addSql('CREATE INDEX IDX_B30096371EBAF6CC ON liste_article (articles_id)');
        $this->addSql('CREATE INDEX IDX_B30096376F91B382 ON liste_article (listes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_article MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE liste_article DROP FOREIGN KEY FK_B30096371EBAF6CC');
        $this->addSql('ALTER TABLE liste_article DROP FOREIGN KEY FK_B30096376F91B382');
        $this->addSql('DROP INDEX IDX_B30096371EBAF6CC ON liste_article');
        $this->addSql('DROP INDEX IDX_B30096376F91B382 ON liste_article');
        $this->addSql('DROP INDEX `PRIMARY` ON liste_article');
        $this->addSql('ALTER TABLE liste_article ADD liste_id INT NOT NULL, ADD article_id INT NOT NULL, DROP id, DROP articles_id, DROP listes_id, DROP est_achete, DROP quantite');
        $this->addSql('ALTER TABLE liste_article ADD CONSTRAINT FK_B30096377294869C FOREIGN KEY (article_id) REFERENCES article (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_article ADD CONSTRAINT FK_B3009637E85441D8 FOREIGN KEY (liste_id) REFERENCES liste (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_B3009637E85441D8 ON liste_article (liste_id)');
        $this->addSql('CREATE INDEX IDX_B30096377294869C ON liste_article (article_id)');
        $this->addSql('ALTER TABLE liste_article ADD PRIMARY KEY (liste_id, article_id)');
    }
}
