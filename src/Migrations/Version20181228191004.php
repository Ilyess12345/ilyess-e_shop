<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181228191004 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produit_commande DROP FOREIGN KEY FK_47F5946EBCF5E72D');
        $this->addSql('DROP INDEX IDX_47F5946EBCF5E72D ON produit_commande');
        $this->addSql('ALTER TABLE produit_commande CHANGE categorie_id commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946E82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_47F5946E82EA2E54 ON produit_commande (commande_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produit_commande DROP FOREIGN KEY FK_47F5946E82EA2E54');
        $this->addSql('DROP INDEX IDX_47F5946E82EA2E54 ON produit_commande');
        $this->addSql('ALTER TABLE produit_commande CHANGE commande_id categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_47F5946EBCF5E72D ON produit_commande (categorie_id)');
    }
}
