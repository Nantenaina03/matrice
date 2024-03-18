<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240221050239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quotpart (id INT AUTO_INCREMENT NOT NULL, pr INT DEFAULT NULL, pt INT DEFAULT NULL, nic INT DEFAULT NULL, i INT DEFAULT NULL, total INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, maternite INT NOT NULL, medecine INT NOT NULL, actes_chirurgicaux INT DEFAULT NULL, pediatrie INT DEFAULT NULL, ophtalmo INT DEFAULT NULL, atu INT DEFAULT NULL, banque_de_sang INT DEFAULT NULL, tiers_service INT DEFAULT NULL, rpe_actes INT DEFAULT NULL, ce_cm INT DEFAULT NULL, part_med INT DEFAULT NULL, rpe INT DEFAULT NULL, ecg INT DEFAULT NULL, echo INT DEFAULT NULL, radio INT DEFAULT NULL, labo INT DEFAULT NULL, compte_lim INT DEFAULT NULL, rpe_2 INT DEFAULT NULL, stomato INT DEFAULT NULL, compte_stomato INT DEFAULT NULL, compte_rpe INT DEFAULT NULL, hebergement_salle_payante INT DEFAULT NULL, total_rpe INT DEFAULT NULL, rp_non_permanent INT DEFAULT NULL, rpe_instruction_permanent INT DEFAULT NULL, autorise_fonctionnement INT DEFAULT NULL, fond_de_secours INT DEFAULT NULL, primes_rendement INT DEFAULT NULL, compte_feh INT DEFAULT NULL, hebergement_salle_commune INT DEFAULT NULL, marge_beneficiaire INT DEFAULT NULL, dons INT DEFAULT NULL, fonds_equite INT DEFAULT NULL, fonds_urgence INT NOT NULL, fonctionnement INT DEFAULT NULL, primes_interessement INT DEFAULT NULL, mois INT NOT NULL, annees INT NOT NULL, trimestre1 INT DEFAULT NULL, trimestre2 INT DEFAULT NULL, trimestre3 INT DEFAULT NULL, trimestre4 INT DEFAULT NULL, INDEX IDX_49BB6390B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source (id INT AUTO_INCREMENT NOT NULL, x INT DEFAULT NULL, y INT DEFAULT NULL, z INT DEFAULT NULL, z1 INT DEFAULT NULL, n INT DEFAULT NULL, fi INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390B03A8386');
        $this->addSql('DROP TABLE quotpart');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE source');
        $this->addSql('DROP TABLE user');
    }
}
