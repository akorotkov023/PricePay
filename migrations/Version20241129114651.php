<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241129114651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE coupon_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE coupon (id INT NOT NULL, code VARCHAR(10) NOT NULL, type VARCHAR(10) NOT NULL, value INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64BF3F0277153098 ON coupon (code)');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        // Добавление записей в таблицу product
        $this->addSql("INSERT INTO product (id, name, price) VALUES (1, 'Iphone', 10000)");
        $this->addSql("INSERT INTO product (id, name, price) VALUES (2, 'Наушники', 2000)");
        $this->addSql("INSERT INTO product (id, name, price) VALUES (3, 'Чехол', 1000)");
        // Добавление записей в таблицу coupon
        $this->addSql("INSERT INTO coupon (id, code, type, value) VALUES (1, 'P10', 'fixed', 1000)");
        $this->addSql("INSERT INTO coupon (id, code, type, value) VALUES (2, 'P30', 'fixed', 3000)");
        $this->addSql("INSERT INTO coupon (id, code, type, value) VALUES (3, 'P5', 'percentage', 500)");
        $this->addSql("INSERT INTO coupon (id, code, type, value) VALUES (4, 'P15', 'percentage', 1500)");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE coupon_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE product');
    }
}
