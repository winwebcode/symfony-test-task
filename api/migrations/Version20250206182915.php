<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250206182915 extends AbstractMigration
{

    public function getDescription(): string
    {
        return 'Add model table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE car ADD model_id INT NOT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('CREATE INDEX IDX_773DE69D7975B7E7 ON car (model_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX IDX_773DE69D7975B7E7 ON car');
        $this->addSql('ALTER TABLE car DROP model_id');
        $this->addSql('DROP TABLE model');
    }
}
