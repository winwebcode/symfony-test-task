<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250206134424 extends AbstractMigration
{

    public function getDescription(): string
    {
        return 'Create brand and car tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, photo VARCHAR(255) NOT NULL, price INT NOT NULL, INDEX IDX_773DE69D44F5D008 (brand_id), PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D44F5D008');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE car');
    }
}
