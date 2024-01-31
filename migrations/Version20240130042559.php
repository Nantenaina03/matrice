<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240130042559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quotpart (id INT AUTO_INCREMENT NOT NULL, pr INT DEFAULT NULL, pt INT DEFAULT NULL, nic INT DEFAULT NULL, i INT DEFAULT NULL, total INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, maternite INT NOT NULL, medecine INT NOT NULL, actes_chirurgicaux INT DEFAULT NULL, pediatrie INT DEFAULT NULL, ophtalmo INT DEFAULT NULL, atu INT DEFAULT NULL, banque_de_sang INT DEFAULT NULL, tiers_service INT DEFAULT NULL, rpe_actes INT DEFAULT NULL, ce_cm INT DEFAULT NULL, part_med INT DEFAULT NULL, rpe INT DEFAULT NULL, ecg INT DEFAULT NULL, echo INT DEFAULT NULL, radio INT DEFAULT NULL, labo INT DEFAULT NULL, compte_lim INT DEFAULT NULL, rpe_2 INT DEFAULT NULL, stomato INT DEFAULT NULL, compte_stomato INT DEFAULT NULL, compte_rpe INT DEFAULT NULL, hebergement_salle_payante INT DEFAULT NULL, total_rpe INT DEFAULT NULL, rp_non_permanent INT DEFAULT NULL, rpe_instruction_permanent INT DEFAULT NULL, autorise_fonctionnement INT DEFAULT NULL, fond_de_secours INT DEFAULT NULL, primes_rendement INT DEFAULT NULL, compte_feh INT DEFAULT NULL, hebergement_salle_commune INT DEFAULT NULL, marge_beneficiaire INT DEFAULT NULL, dons INT DEFAULT NULL, fonds_equite INT DEFAULT NULL, fonds_urgence INT NOT NULL, fonctionnement INT DEFAULT NULL, primes_interessement INT DEFAULT NULL, mois INT NOT NULL, annees INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source (id INT AUTO_INCREMENT NOT NULL, x INT DEFAULT NULL, y INT DEFAULT NULL, z INT DEFAULT NULL, z1 INT DEFAULT NULL, n INT DEFAULT NULL, fi INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE quotpart');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE source');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
