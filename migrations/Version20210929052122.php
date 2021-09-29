<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210929052122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, property_id INTEGER NOT NULL, mail_customer VARCHAR(100) NOT NULL, date_of DATETIME NOT NULL, message CLOB NOT NULL)');
        $this->addSql('CREATE INDEX IDX_FE38F844549213EC ON appointment (property_id)');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP INDEX IDX_16DB4F89549213EC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__picture AS SELECT id, property_id, name FROM picture');
        $this->addSql('DROP TABLE picture');
        $this->addSql('CREATE TABLE picture (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, property_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL COLLATE BINARY, CONSTRAINT FK_16DB4F89549213EC FOREIGN KEY (property_id) REFERENCES property (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO picture (id, property_id, name) SELECT id, property_id, name FROM __temp__picture');
        $this->addSql('DROP TABLE __temp__picture');
        $this->addSql('CREATE INDEX IDX_16DB4F89549213EC ON picture (property_id)');
        $this->addSql('DROP INDEX IDX_8BF21CDE8C03F15C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__property AS SELECT id, employee_id, title, surface, content, price, floor, rooms, address, zipcode, city, type, transaction_type, ground_size, date_of_construction, sell, slug FROM property');
        $this->addSql('DROP TABLE property');
        $this->addSql('CREATE TABLE property (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, employee_id INTEGER NOT NULL, title VARCHAR(60) NOT NULL COLLATE BINARY, surface INTEGER NOT NULL, content VARCHAR(255) NOT NULL COLLATE BINARY, price INTEGER NOT NULL, floor INTEGER DEFAULT NULL, rooms INTEGER NOT NULL, address VARCHAR(120) NOT NULL COLLATE BINARY, zipcode VARCHAR(10) NOT NULL COLLATE BINARY, city VARCHAR(120) NOT NULL COLLATE BINARY, type VARCHAR(30) NOT NULL COLLATE BINARY, transaction_type VARCHAR(30) NOT NULL COLLATE BINARY, ground_size INTEGER NOT NULL, date_of_construction INTEGER DEFAULT NULL, sell BOOLEAN NOT NULL, slug VARCHAR(100) NOT NULL COLLATE BINARY, CONSTRAINT FK_8BF21CDE8C03F15C FOREIGN KEY (employee_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO property (id, employee_id, title, surface, content, price, floor, rooms, address, zipcode, city, type, transaction_type, ground_size, date_of_construction, sell, slug) SELECT id, employee_id, title, surface, content, price, floor, rooms, address, zipcode, city, type, transaction_type, ground_size, date_of_construction, sell, slug FROM __temp__property');
        $this->addSql('DROP TABLE __temp__property');
        $this->addSql('CREATE INDEX IDX_8BF21CDE8C03F15C ON property (employee_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, firstname, lastname, phone, is_verified FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, firstname VARCHAR(30) NOT NULL COLLATE BINARY, lastname VARCHAR(30) NOT NULL COLLATE BINARY, is_verified BOOLEAN NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , phone VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password, firstname, lastname, phone, is_verified) SELECT id, email, roles, password, firstname, lastname, phone, is_verified FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(120) NOT NULL COLLATE BINARY, firstname VARCHAR(30) NOT NULL COLLATE BINARY, lastname VARCHAR(30) NOT NULL COLLATE BINARY)');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP INDEX IDX_16DB4F89549213EC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__picture AS SELECT id, property_id, name FROM picture');
        $this->addSql('DROP TABLE picture');
        $this->addSql('CREATE TABLE picture (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, property_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL)');
        $this->addSql('INSERT INTO picture (id, property_id, name) SELECT id, property_id, name FROM __temp__picture');
        $this->addSql('DROP TABLE __temp__picture');
        $this->addSql('CREATE INDEX IDX_16DB4F89549213EC ON picture (property_id)');
        $this->addSql('DROP INDEX IDX_8BF21CDE8C03F15C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__property AS SELECT id, employee_id, title, surface, content, price, floor, rooms, address, zipcode, city, type, transaction_type, ground_size, date_of_construction, sell, slug FROM property');
        $this->addSql('DROP TABLE property');
        $this->addSql('CREATE TABLE property (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, employee_id INTEGER NOT NULL, title VARCHAR(60) NOT NULL, surface INTEGER NOT NULL, content VARCHAR(255) NOT NULL, price INTEGER NOT NULL, floor INTEGER DEFAULT NULL, rooms INTEGER NOT NULL, address VARCHAR(120) NOT NULL, zipcode VARCHAR(10) NOT NULL, city VARCHAR(120) NOT NULL, type VARCHAR(30) NOT NULL, transaction_type VARCHAR(30) NOT NULL, ground_size INTEGER NOT NULL, date_of_construction INTEGER DEFAULT NULL, sell BOOLEAN NOT NULL, slug VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO property (id, employee_id, title, surface, content, price, floor, rooms, address, zipcode, city, type, transaction_type, ground_size, date_of_construction, sell, slug) SELECT id, employee_id, title, surface, content, price, floor, rooms, address, zipcode, city, type, transaction_type, ground_size, date_of_construction, sell, slug FROM __temp__property');
        $this->addSql('DROP TABLE __temp__property');
        $this->addSql('CREATE INDEX IDX_8BF21CDE8C03F15C ON property (employee_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, firstname, lastname, phone, is_verified FROM "user"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(30) NOT NULL, lastname VARCHAR(30) NOT NULL, is_verified BOOLEAN NOT NULL, roles CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        , phone INTEGER NOT NULL)');
        $this->addSql('INSERT INTO "user" (id, email, roles, password, firstname, lastname, phone, is_verified) SELECT id, email, roles, password, firstname, lastname, phone, is_verified FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
    }
}
