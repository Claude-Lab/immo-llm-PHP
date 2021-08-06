<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210725105709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(180) NOT NULL, post_code VARCHAR(20) NOT NULL, city VARCHAR(180) NOT NULL, state VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract (id INT AUTO_INCREMENT NOT NULL, housing_id INT NOT NULL, INDEX IDX_E98F2859AD5873E3 (housing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, housing_id INT DEFAULT NULL, name VARCHAR(180) NOT NULL, brand VARCHAR(150) NOT NULL, serial_number VARCHAR(255) DEFAULT NULL, in_use TINYINT(1) NOT NULL, INDEX IDX_D338D583AD5873E3 (housing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guaranty (id INT AUTO_INCREMENT NOT NULL, contract_id INT DEFAULT NULL, INDEX IDX_E2BFE5312576E0FD (contract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heat (id INT AUTO_INCREMENT NOT NULL, energy VARCHAR(100) NOT NULL, setup VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE housing (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, sort_id INT NOT NULL, heat_id INT NOT NULL, nb_room INT NOT NULL, surface DOUBLE PRECISION NOT NULL, rental DOUBLE PRECISION DEFAULT NULL, housing_load DOUBLE PRECISION DEFAULT NULL, floor INT DEFAULT NULL, attic TINYINT(1) DEFAULT NULL, cellar TINYINT(1) DEFAULT NULL, pool TINYINT(1) DEFAULT NULL, box TINYINT(1) DEFAULT NULL, land_surface DOUBLE PRECISION DEFAULT NULL, nb_floor INT DEFAULT NULL, elevator TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_FB8142C3F5B7AF75 (address_id), INDEX IDX_FB8142C347013001 (sort_id), INDEX IDX_FB8142C3A4033601 (heat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_load (id INT AUTO_INCREMENT NOT NULL, housing_id INT DEFAULT NULL, quarter INT NOT NULL, rate DOUBLE PRECISION NOT NULL, date_load DATETIME NOT NULL, INDEX IDX_3A1E5B27AD5873E3 (housing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receipt (id INT AUTO_INCREMENT NOT NULL, contract_id INT NOT NULL, name VARCHAR(255) NOT NULL, date DATETIME NOT NULL, rental DOUBLE PRECISION NOT NULL, rental_load DOUBLE PRECISION NOT NULL, INDEX IDX_5399B6452576E0FD (contract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sort (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tax (id INT AUTO_INCREMENT NOT NULL, housing_id INT DEFAULT NULL, property_tax VARCHAR(150) NOT NULL, rate DOUBLE PRECISION NOT NULL, date_tax DATETIME NOT NULL, INDEX IDX_8E81BA76AD5873E3 (housing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tenant (id INT AUTO_INCREMENT NOT NULL, address_before_id INT DEFAULT NULL, address_after_id INT DEFAULT NULL, contract_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_4E59C46291F843F7 (address_before_id), UNIQUE INDEX UNIQ_4E59C462F6DD3BCD (address_after_id), INDEX IDX_4E59C4622576E0FD (contract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859AD5873E3 FOREIGN KEY (housing_id) REFERENCES housing (id)');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D583AD5873E3 FOREIGN KEY (housing_id) REFERENCES housing (id)');
        $this->addSql('ALTER TABLE guaranty ADD CONSTRAINT FK_E2BFE5312576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE housing ADD CONSTRAINT FK_FB8142C3F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE housing ADD CONSTRAINT FK_FB8142C347013001 FOREIGN KEY (sort_id) REFERENCES sort (id)');
        $this->addSql('ALTER TABLE housing ADD CONSTRAINT FK_FB8142C3A4033601 FOREIGN KEY (heat_id) REFERENCES heat (id)');
        $this->addSql('ALTER TABLE property_load ADD CONSTRAINT FK_3A1E5B27AD5873E3 FOREIGN KEY (housing_id) REFERENCES housing (id)');
        $this->addSql('ALTER TABLE receipt ADD CONSTRAINT FK_5399B6452576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE tax ADD CONSTRAINT FK_8E81BA76AD5873E3 FOREIGN KEY (housing_id) REFERENCES housing (id)');
        $this->addSql('ALTER TABLE tenant ADD CONSTRAINT FK_4E59C46291F843F7 FOREIGN KEY (address_before_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE tenant ADD CONSTRAINT FK_4E59C462F6DD3BCD FOREIGN KEY (address_after_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE tenant ADD CONSTRAINT FK_4E59C4622576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE housing DROP FOREIGN KEY FK_FB8142C3F5B7AF75');
        $this->addSql('ALTER TABLE tenant DROP FOREIGN KEY FK_4E59C46291F843F7');
        $this->addSql('ALTER TABLE tenant DROP FOREIGN KEY FK_4E59C462F6DD3BCD');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F5B7AF75');
        $this->addSql('ALTER TABLE guaranty DROP FOREIGN KEY FK_E2BFE5312576E0FD');
        $this->addSql('ALTER TABLE receipt DROP FOREIGN KEY FK_5399B6452576E0FD');
        $this->addSql('ALTER TABLE tenant DROP FOREIGN KEY FK_4E59C4622576E0FD');
        $this->addSql('ALTER TABLE housing DROP FOREIGN KEY FK_FB8142C3A4033601');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F2859AD5873E3');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D583AD5873E3');
        $this->addSql('ALTER TABLE property_load DROP FOREIGN KEY FK_3A1E5B27AD5873E3');
        $this->addSql('ALTER TABLE tax DROP FOREIGN KEY FK_8E81BA76AD5873E3');
        $this->addSql('ALTER TABLE housing DROP FOREIGN KEY FK_FB8142C347013001');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE guaranty');
        $this->addSql('DROP TABLE heat');
        $this->addSql('DROP TABLE housing');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE property_load');
        $this->addSql('DROP TABLE receipt');
        $this->addSql('DROP TABLE sort');
        $this->addSql('DROP TABLE tax');
        $this->addSql('DROP TABLE tenant');
        $this->addSql('DROP TABLE user');
    }
}
