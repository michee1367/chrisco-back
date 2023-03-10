<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230305145856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, province_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2D5B0234E946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE household (id INT AUTO_INCREMENT NOT NULL, territory_id INT DEFAULT NULL, town_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, INDEX IDX_54C32FC073F74AD4 (territory_id), INDEX IDX_54C32FC075E23604 (town_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parish (id INT AUTO_INCREMENT NOT NULL, presbytery_id INT DEFAULT NULL, town_id INT DEFAULT NULL, territory_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, INDEX IDX_DFF9A978CCBD285F (presbytery_id), INDEX IDX_DFF9A97875E23604 (town_id), INDEX IDX_DFF9A97873F74AD4 (territory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE presbytery (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE province (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE territory (id INT AUTO_INCREMENT NOT NULL, province_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E9743966E946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE territory_presbytery (id INT AUTO_INCREMENT NOT NULL, presbytery_id INT DEFAULT NULL, territory_id INT DEFAULT NULL, INDEX IDX_DF6E0BB5CCBD285F (presbytery_id), INDEX IDX_DF6E0BB573F74AD4 (territory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE town (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_4CE6C7A48BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE town_presbytery (id INT AUTO_INCREMENT NOT NULL, town_id INT DEFAULT NULL, presbytery_id INT DEFAULT NULL, INDEX IDX_2EE0A17E75E23604 (town_id), INDEX IDX_2EE0A17ECCBD285F (presbytery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, whatsapp_phone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234E946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE household ADD CONSTRAINT FK_54C32FC073F74AD4 FOREIGN KEY (territory_id) REFERENCES territory (id)');
        $this->addSql('ALTER TABLE household ADD CONSTRAINT FK_54C32FC075E23604 FOREIGN KEY (town_id) REFERENCES town (id)');
        $this->addSql('ALTER TABLE parish ADD CONSTRAINT FK_DFF9A978CCBD285F FOREIGN KEY (presbytery_id) REFERENCES presbytery (id)');
        $this->addSql('ALTER TABLE parish ADD CONSTRAINT FK_DFF9A97875E23604 FOREIGN KEY (town_id) REFERENCES town (id)');
        $this->addSql('ALTER TABLE parish ADD CONSTRAINT FK_DFF9A97873F74AD4 FOREIGN KEY (territory_id) REFERENCES territory (id)');
        $this->addSql('ALTER TABLE territory ADD CONSTRAINT FK_E9743966E946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE territory_presbytery ADD CONSTRAINT FK_DF6E0BB5CCBD285F FOREIGN KEY (presbytery_id) REFERENCES presbytery (id)');
        $this->addSql('ALTER TABLE territory_presbytery ADD CONSTRAINT FK_DF6E0BB573F74AD4 FOREIGN KEY (territory_id) REFERENCES territory (id)');
        $this->addSql('ALTER TABLE town ADD CONSTRAINT FK_4CE6C7A48BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE town_presbytery ADD CONSTRAINT FK_2EE0A17E75E23604 FOREIGN KEY (town_id) REFERENCES town (id)');
        $this->addSql('ALTER TABLE town_presbytery ADD CONSTRAINT FK_2EE0A17ECCBD285F FOREIGN KEY (presbytery_id) REFERENCES presbytery (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234E946114A');
        $this->addSql('ALTER TABLE household DROP FOREIGN KEY FK_54C32FC073F74AD4');
        $this->addSql('ALTER TABLE household DROP FOREIGN KEY FK_54C32FC075E23604');
        $this->addSql('ALTER TABLE parish DROP FOREIGN KEY FK_DFF9A978CCBD285F');
        $this->addSql('ALTER TABLE parish DROP FOREIGN KEY FK_DFF9A97875E23604');
        $this->addSql('ALTER TABLE parish DROP FOREIGN KEY FK_DFF9A97873F74AD4');
        $this->addSql('ALTER TABLE territory DROP FOREIGN KEY FK_E9743966E946114A');
        $this->addSql('ALTER TABLE territory_presbytery DROP FOREIGN KEY FK_DF6E0BB5CCBD285F');
        $this->addSql('ALTER TABLE territory_presbytery DROP FOREIGN KEY FK_DF6E0BB573F74AD4');
        $this->addSql('ALTER TABLE town DROP FOREIGN KEY FK_4CE6C7A48BAC62AF');
        $this->addSql('ALTER TABLE town_presbytery DROP FOREIGN KEY FK_2EE0A17E75E23604');
        $this->addSql('ALTER TABLE town_presbytery DROP FOREIGN KEY FK_2EE0A17ECCBD285F');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE household');
        $this->addSql('DROP TABLE parish');
        $this->addSql('DROP TABLE presbytery');
        $this->addSql('DROP TABLE province');
        $this->addSql('DROP TABLE territory');
        $this->addSql('DROP TABLE territory_presbytery');
        $this->addSql('DROP TABLE town');
        $this->addSql('DROP TABLE town_presbytery');
        $this->addSql('DROP TABLE `user`');
    }
}
