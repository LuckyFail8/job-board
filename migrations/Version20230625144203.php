<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230625144203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, name VARCHAR(55) NOT NULL, postal_code INT DEFAULT NULL, INDEX IDX_2D5B023498260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city_company (city_id INT NOT NULL, company_id INT NOT NULL, INDEX IDX_F2F7B71D8BAC62AF (city_id), INDEX IDX_F2F7B71D979B1AD6 (company_id), PRIMARY KEY(city_id, company_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_offer (id INT AUTO_INCREMENT NOT NULL, platform_id INT DEFAULT NULL, company_id INT DEFAULT NULL, adress VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, remote TINYINT(1) DEFAULT NULL, day_per_week INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, publish_date DATE DEFAULT NULL, status VARCHAR(40) NOT NULL, feedback LONGTEXT DEFAULT NULL, INDEX IDX_288A3A4EFFE6496F (platform_id), INDEX IDX_288A3A4E979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_offer_technologie (job_offer_id INT NOT NULL, technologie_id INT NOT NULL, INDEX IDX_28A54A8F3481D195 (job_offer_id), INDEX IDX_28A54A8F261A27D2 (technologie_id), PRIMARY KEY(job_offer_id, technologie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_offer_city (job_offer_id INT NOT NULL, city_id INT NOT NULL, INDEX IDX_B9D4BC3E3481D195 (job_offer_id), INDEX IDX_B9D4BC3E8BAC62AF (city_id), PRIMARY KEY(job_offer_id, city_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE platform (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, department_code INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technologie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B023498260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE city_company ADD CONSTRAINT FK_F2F7B71D8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE city_company ADD CONSTRAINT FK_F2F7B71D979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4EFFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id)');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4E979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE job_offer_technologie ADD CONSTRAINT FK_28A54A8F3481D195 FOREIGN KEY (job_offer_id) REFERENCES job_offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_offer_technologie ADD CONSTRAINT FK_28A54A8F261A27D2 FOREIGN KEY (technologie_id) REFERENCES technologie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_offer_city ADD CONSTRAINT FK_B9D4BC3E3481D195 FOREIGN KEY (job_offer_id) REFERENCES job_offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_offer_city ADD CONSTRAINT FK_B9D4BC3E8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B023498260155');
        $this->addSql('ALTER TABLE city_company DROP FOREIGN KEY FK_F2F7B71D8BAC62AF');
        $this->addSql('ALTER TABLE city_company DROP FOREIGN KEY FK_F2F7B71D979B1AD6');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4EFFE6496F');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4E979B1AD6');
        $this->addSql('ALTER TABLE job_offer_technologie DROP FOREIGN KEY FK_28A54A8F3481D195');
        $this->addSql('ALTER TABLE job_offer_technologie DROP FOREIGN KEY FK_28A54A8F261A27D2');
        $this->addSql('ALTER TABLE job_offer_city DROP FOREIGN KEY FK_B9D4BC3E3481D195');
        $this->addSql('ALTER TABLE job_offer_city DROP FOREIGN KEY FK_B9D4BC3E8BAC62AF');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE city_company');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE job_offer');
        $this->addSql('DROP TABLE job_offer_technologie');
        $this->addSql('DROP TABLE job_offer_city');
        $this->addSql('DROP TABLE platform');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE technologie');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
