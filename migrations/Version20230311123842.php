<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230311123842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE config_insert_agromwinda_places');
        $this->addSql('ALTER TABLE user ADD territory_id INT DEFAULT NULL, ADD town_id INT DEFAULT NULL, ADD address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64973F74AD4 FOREIGN KEY (territory_id) REFERENCES territory (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64975E23604 FOREIGN KEY (town_id) REFERENCES town (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64973F74AD4 ON user (territory_id)');
        $this->addSql('CREATE INDEX IDX_8D93D64975E23604 ON user (town_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE config_insert_agromwinda_places (id INT AUTO_INCREMENT NOT NULL, entity_iri VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, app_id INT NOT NULL, UNIQUE INDEX entity_iri (entity_iri), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64973F74AD4');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64975E23604');
        $this->addSql('DROP INDEX IDX_8D93D64973F74AD4 ON `user`');
        $this->addSql('DROP INDEX IDX_8D93D64975E23604 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP territory_id, DROP town_id, DROP address');
    }
}
