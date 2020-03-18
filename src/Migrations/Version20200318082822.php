<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200318082822 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE expense_category DROP FOREIGN KEY FK_C02DDB38727ACA70');
        $this->addSql('ALTER TABLE income_category DROP FOREIGN KEY FK_2F2D922F727ACA70');
        $this->addSql('CREATE TABLE category_expense (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_EAE2CDD8727ACA70 (parent_id), INDEX IDX_EAE2CDD8A76ED395 (user_id), UNIQUE INDEX category_expense_uq (user_id, parent_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_income (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3040A8AB727ACA70 (parent_id), INDEX IDX_3040A8ABA76ED395 (user_id), UNIQUE INDEX category_income_uq (user_id, parent_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_expense ADD CONSTRAINT FK_EAE2CDD8727ACA70 FOREIGN KEY (parent_id) REFERENCES category_expense (id)');
        $this->addSql('ALTER TABLE category_expense ADD CONSTRAINT FK_EAE2CDD8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE category_income ADD CONSTRAINT FK_3040A8AB727ACA70 FOREIGN KEY (parent_id) REFERENCES category_income (id)');
        $this->addSql('ALTER TABLE category_income ADD CONSTRAINT FK_3040A8ABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation_income DROP FOREIGN KEY FK_4228DBB212469DE2');
        $this->addSql('ALTER TABLE operation_income ADD CONSTRAINT FK_4228DBB212469DE2 FOREIGN KEY (category_id) REFERENCES category_income (id)');
        $this->addSql('ALTER TABLE operation_expense DROP FOREIGN KEY FK_8EFB0D6B12469DE2');
        $this->addSql('ALTER TABLE operation_expense ADD CONSTRAINT FK_8EFB0D6B12469DE2 FOREIGN KEY (category_id) REFERENCES category_expense (id)');
        $this->addSql('DROP TABLE expense_category');
        $this->addSql('DROP TABLE income_category');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category_expense DROP FOREIGN KEY FK_EAE2CDD8727ACA70');
        $this->addSql('ALTER TABLE category_income DROP FOREIGN KEY FK_3040A8AB727ACA70');
        $this->addSql('CREATE TABLE expense_category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, user_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, icon VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C02DDB38727ACA70 (parent_id), UNIQUE INDEX expense_category_uq (user_id, parent_id, name), INDEX IDX_C02DDB38A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE income_category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, user_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, icon VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2F2D922F727ACA70 (parent_id), UNIQUE INDEX income_category_uq (user_id, parent_id, name), INDEX IDX_2F2D922FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE expense_category ADD CONSTRAINT FK_C02DDB38727ACA70 FOREIGN KEY (parent_id) REFERENCES expense_category (id)');
        $this->addSql('ALTER TABLE expense_category ADD CONSTRAINT FK_C02DDB38A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE income_category ADD CONSTRAINT FK_2F2D922F727ACA70 FOREIGN KEY (parent_id) REFERENCES income_category (id)');
        $this->addSql('ALTER TABLE income_category ADD CONSTRAINT FK_2F2D922FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation_expense DROP FOREIGN KEY FK_8EFB0D6B12469DE2');
        $this->addSql('ALTER TABLE operation_expense ADD CONSTRAINT FK_8EFB0D6B12469DE2 FOREIGN KEY (category_id) REFERENCES expense_category (id)');
        $this->addSql('ALTER TABLE operation_income DROP FOREIGN KEY FK_4228DBB212469DE2');
        $this->addSql('ALTER TABLE operation_income ADD CONSTRAINT FK_4228DBB212469DE2 FOREIGN KEY (category_id) REFERENCES income_category (id)');
        $this->addSql('DROP TABLE category_expense');
        $this->addSql('DROP TABLE category_income');
    }
}
