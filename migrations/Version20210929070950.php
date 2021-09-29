<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210929070950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, property_id INTEGER NOT NULL, mail_customer VARCHAR(100) NOT NULL, date_of DATETIME NOT NULL, message CLOB NOT NULL, firstname_customer VARCHAR(60) NOT NULL, lastname_customer VARCHAR(60) NOT NULL, phone_customer VARCHAR(15) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_FE38F844549213EC ON appointment (property_id)');
        $this->addSql('CREATE TABLE picture (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, property_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_16DB4F89549213EC ON picture (property_id)');
        $this->addSql('CREATE TABLE property (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, employee_id INTEGER NOT NULL, title VARCHAR(60) NOT NULL, surface INTEGER NOT NULL, content VARCHAR(255) NOT NULL, price INTEGER NOT NULL, floor INTEGER DEFAULT NULL, rooms INTEGER NOT NULL, address VARCHAR(120) NOT NULL, zipcode VARCHAR(10) NOT NULL, city VARCHAR(120) NOT NULL, type VARCHAR(30) NOT NULL, transaction_type VARCHAR(30) NOT NULL, ground_size INTEGER NOT NULL, date_of_construction INTEGER DEFAULT NULL, sell BOOLEAN NOT NULL, slug VARCHAR(100) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_8BF21CDE8C03F15C ON property (employee_id)');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, firstname VARCHAR(30) NOT NULL, lastname VARCHAR(30) NOT NULL, phone VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE "user"');
    }
}
