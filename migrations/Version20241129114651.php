<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241129114651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE coupon (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, code VARCHAR(10) NOT NULL, type VARCHAR(10) NOT NULL, value INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE country (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, country VARCHAR(255) NOT NULL, slug VARCHAR(2) NOT NULL, tax_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE country_tax (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, tax INT NOT NULL, PRIMARY KEY(id))');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_64BF3F0277153098 ON coupon (code)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5373C966989D9B62 ON country (slug)');

        // Добавление записей в таблицу product
        $this->addSql("INSERT INTO product (id, name, price) VALUES (1, 'Iphone', 10000)");
        $this->addSql("INSERT INTO product (id, name, price) VALUES (2, 'Наушники', 2000)");
        $this->addSql("INSERT INTO product (id, name, price) VALUES (3, 'Чехол', 1000)");
        // Добавление записей в таблицу coupon
        $this->addSql("INSERT INTO coupon (id, code, type, value) VALUES (1, 'F10', 'fixed', 1000)");
        $this->addSql("INSERT INTO coupon (id, code, type, value) VALUES (2, 'F20', 'fixed', 2000)");
        $this->addSql("INSERT INTO coupon (id, code, type, value) VALUES (3, 'P5', 'percentage', 5)");
        $this->addSql("INSERT INTO coupon (id, code, type, value) VALUES (4, 'P15', 'percentage', 15)");

//        $this->addSql("INSERT INTO country_tax (id, country, tax, slug) VALUES (1, 'Германия', 19, 'DE')");
//        $this->addSql("INSERT INTO country_tax (id, country, tax, slug) VALUES (2, 'Италия', 22, 'IT')");
//        $this->addSql("INSERT INTO country_tax (id, country, tax, slug) VALUES (3, 'Франция', 20, 'FR')");
//        $this->addSql("INSERT INTO country_tax (id, country, tax, slug) VALUES (4, 'Греция', 24, 'GR')");
        // Добавление записей в таблицу country
        $this->addSql("INSERT INTO country (id, country, slug) VALUES (1, 'Германия', 'DE')");
        $this->addSql("INSERT INTO country (id, country, slug) VALUES (2, 'Италия', 'IT')");
        $this->addSql("INSERT INTO country (id, country, slug) VALUES (3, 'Франция', 'FR')");
        $this->addSql("INSERT INTO country (id, country, slug) VALUES (4, 'Греция', 'GR')");
        // Добавление записей в таблицу country_tax
        $this->addSql("INSERT INTO country_tax (id, tax) VALUES (1, 19)");
        $this->addSql("INSERT INTO country_tax (id, tax) VALUES (2, 22)");
        $this->addSql("INSERT INTO country_tax (id, tax) VALUES (3, 20)");
        $this->addSql("INSERT INTO country_tax (id, tax) VALUES (4, 24)");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE country_tax');
        $this->addSql('DROP TABLE product_country_tax');
        $this->addSql('DROP INDEX UNIQ_B5A98CE7989D9B62');
    }
}
