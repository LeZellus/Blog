<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210909125109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profil_thumb (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD profil_thumb_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DBEA3B08 FOREIGN KEY (profil_thumb_id) REFERENCES profil_thumb (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649DBEA3B08 ON user (profil_thumb_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649DBEA3B08');
        $this->addSql('DROP TABLE profil_thumb');
        $this->addSql('DROP INDEX UNIQ_8D93D649DBEA3B08 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP profil_thumb_id');
    }
}
