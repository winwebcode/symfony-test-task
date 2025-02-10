<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210075605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE credit_request (    
            id INT AUTO_INCREMENT NOT NULL,
            car_id INT NOT NULL,
            credit_program_id INT NOT NULL,
            initial_payment INT NOT NULL,
            loan_term INT NOT NULL,
            PRIMARY KEY(id)
        )');

        $this->addSql('ALTER TABLE credit_request ADD CONSTRAINT FK_C097AF4C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)'); 
        $this->addSql('ALTER TABLE credit_request ADD CONSTRAINT FK_C097AF43EB8070A FOREIGN KEY (credit_program_id) REFERENCES credit_program (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE credit_request');
    }
}
