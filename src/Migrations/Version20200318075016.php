<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200318075016 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE operation_transfer (id INT AUTO_INCREMENT NOT NULL, source_id INT DEFAULT NULL, target_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A542DC4D953C1C61 (source_id), INDEX IDX_A542DC4D158E0B66 (target_id), INDEX IDX_A542DC4DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation_debt (id INT AUTO_INCREMENT NOT NULL, account_id INT DEFAULT NULL, person_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F4CF57129B6B5FBA (account_id), INDEX IDX_F4CF5712217BBB47 (person_id), INDEX IDX_F4CF5712A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation_debt_collection (id INT AUTO_INCREMENT NOT NULL, account_id INT DEFAULT NULL, person_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2E0BA3589B6B5FBA (account_id), INDEX IDX_2E0BA358217BBB47 (person_id), INDEX IDX_2E0BA358A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation_expense (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, account_id INT DEFAULT NULL, tag_id INT DEFAULT NULL, fund_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8EFB0D6B12469DE2 (category_id), INDEX IDX_8EFB0D6B9B6B5FBA (account_id), INDEX IDX_8EFB0D6BBAD26311 (tag_id), INDEX IDX_8EFB0D6B25A38F89 (fund_id), INDEX IDX_8EFB0D6BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation_income (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, account_id INT DEFAULT NULL, tag_id INT DEFAULT NULL, fund_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4228DBB212469DE2 (category_id), INDEX IDX_4228DBB29B6B5FBA (account_id), INDEX IDX_4228DBB2BAD26311 (tag_id), INDEX IDX_4228DBB225A38F89 (fund_id), INDEX IDX_4228DBB2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation_loan (id INT AUTO_INCREMENT NOT NULL, account_id INT DEFAULT NULL, person_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_EAA350929B6B5FBA (account_id), INDEX IDX_EAA35092217BBB47 (person_id), INDEX IDX_EAA35092A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation_repayment (id INT AUTO_INCREMENT NOT NULL, account_id INT DEFAULT NULL, person_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C3FF83B39B6B5FBA (account_id), INDEX IDX_C3FF83B3217BBB47 (person_id), INDEX IDX_C3FF83B3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE operation_transfer ADD CONSTRAINT FK_A542DC4D953C1C61 FOREIGN KEY (source_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE operation_transfer ADD CONSTRAINT FK_A542DC4D158E0B66 FOREIGN KEY (target_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE operation_transfer ADD CONSTRAINT FK_A542DC4DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation_debt ADD CONSTRAINT FK_F4CF57129B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE operation_debt ADD CONSTRAINT FK_F4CF5712217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE operation_debt ADD CONSTRAINT FK_F4CF5712A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation_debt_collection ADD CONSTRAINT FK_2E0BA3589B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE operation_debt_collection ADD CONSTRAINT FK_2E0BA358217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE operation_debt_collection ADD CONSTRAINT FK_2E0BA358A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation_expense ADD CONSTRAINT FK_8EFB0D6B12469DE2 FOREIGN KEY (category_id) REFERENCES expense_category (id)');
        $this->addSql('ALTER TABLE operation_expense ADD CONSTRAINT FK_8EFB0D6B9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE operation_expense ADD CONSTRAINT FK_8EFB0D6BBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE operation_expense ADD CONSTRAINT FK_8EFB0D6B25A38F89 FOREIGN KEY (fund_id) REFERENCES fund (id)');
        $this->addSql('ALTER TABLE operation_expense ADD CONSTRAINT FK_8EFB0D6BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation_income ADD CONSTRAINT FK_4228DBB212469DE2 FOREIGN KEY (category_id) REFERENCES income_category (id)');
        $this->addSql('ALTER TABLE operation_income ADD CONSTRAINT FK_4228DBB29B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE operation_income ADD CONSTRAINT FK_4228DBB2BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE operation_income ADD CONSTRAINT FK_4228DBB225A38F89 FOREIGN KEY (fund_id) REFERENCES fund (id)');
        $this->addSql('ALTER TABLE operation_income ADD CONSTRAINT FK_4228DBB2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation_loan ADD CONSTRAINT FK_EAA350929B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE operation_loan ADD CONSTRAINT FK_EAA35092217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE operation_loan ADD CONSTRAINT FK_EAA35092A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation_repayment ADD CONSTRAINT FK_C3FF83B39B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE operation_repayment ADD CONSTRAINT FK_C3FF83B3217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE operation_repayment ADD CONSTRAINT FK_C3FF83B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE debt_collection_operation');
        $this->addSql('DROP TABLE debt_operation');
        $this->addSql('DROP TABLE expense_operation');
        $this->addSql('DROP TABLE income_operation');
        $this->addSql('DROP TABLE loan_operation');
        $this->addSql('DROP TABLE repayment_operation');
        $this->addSql('DROP TABLE transfer_operation');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE debt_collection_operation (id INT AUTO_INCREMENT NOT NULL, target_account_id INT DEFAULT NULL, person_id INT DEFAULT NULL, user_id INT NOT NULL, date DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B70A9D53217BBB47 (person_id), INDEX IDX_B70A9D53A987872B (target_account_id), INDEX IDX_B70A9D53A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE debt_operation (id INT AUTO_INCREMENT NOT NULL, target_account_id INT DEFAULT NULL, person_id INT DEFAULT NULL, user_id INT NOT NULL, date DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6A13AC58217BBB47 (person_id), INDEX IDX_6A13AC58A987872B (target_account_id), INDEX IDX_6A13AC58A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE expense_operation (id INT AUTO_INCREMENT NOT NULL, source_account_id INT DEFAULT NULL, category_id INT DEFAULT NULL, tag_id INT DEFAULT NULL, fund_id INT DEFAULT NULL, user_id INT NOT NULL, date DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_DD268D1712469DE2 (category_id), INDEX IDX_DD268D1725A38F89 (fund_id), INDEX IDX_DD268D17E7DF2E9E (source_account_id), INDEX IDX_DD268D17BAD26311 (tag_id), INDEX IDX_DD268D17A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE income_operation (id INT AUTO_INCREMENT NOT NULL, target_account_id INT DEFAULT NULL, category_id INT DEFAULT NULL, tag_id INT DEFAULT NULL, fund_id INT DEFAULT NULL, user_id INT NOT NULL, date DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5E1A089912469DE2 (category_id), INDEX IDX_5E1A089925A38F89 (fund_id), INDEX IDX_5E1A0899A987872B (target_account_id), INDEX IDX_5E1A0899BAD26311 (tag_id), INDEX IDX_5E1A0899A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE loan_operation (id INT AUTO_INCREMENT NOT NULL, source_account_id INT DEFAULT NULL, person_id INT DEFAULT NULL, user_id INT NOT NULL, date DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_58D29AF7217BBB47 (person_id), INDEX IDX_58D29AF7E7DF2E9E (source_account_id), INDEX IDX_58D29AF7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE repayment_operation (id INT AUTO_INCREMENT NOT NULL, source_account_id INT DEFAULT NULL, person_id INT DEFAULT NULL, user_id INT NOT NULL, date DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4604BFE7217BBB47 (person_id), INDEX IDX_4604BFE7E7DF2E9E (source_account_id), INDEX IDX_4604BFE7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE transfer_operation (id INT AUTO_INCREMENT NOT NULL, source_account_id INT DEFAULT NULL, target_account_id INT DEFAULT NULL, user_id INT NOT NULL, date DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B4079F06A987872B (target_account_id), INDEX IDX_B4079F06E7DF2E9E (source_account_id), INDEX IDX_B4079F06A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE debt_collection_operation ADD CONSTRAINT FK_B70A9D53217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE debt_collection_operation ADD CONSTRAINT FK_B70A9D53A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE debt_collection_operation ADD CONSTRAINT FK_B70A9D53A987872B FOREIGN KEY (target_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE debt_operation ADD CONSTRAINT FK_6A13AC58217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE debt_operation ADD CONSTRAINT FK_6A13AC58A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE debt_operation ADD CONSTRAINT FK_6A13AC58A987872B FOREIGN KEY (target_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE expense_operation ADD CONSTRAINT FK_DD268D1712469DE2 FOREIGN KEY (category_id) REFERENCES expense_category (id)');
        $this->addSql('ALTER TABLE expense_operation ADD CONSTRAINT FK_DD268D1725A38F89 FOREIGN KEY (fund_id) REFERENCES fund (id)');
        $this->addSql('ALTER TABLE expense_operation ADD CONSTRAINT FK_DD268D17A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE expense_operation ADD CONSTRAINT FK_DD268D17BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE expense_operation ADD CONSTRAINT FK_DD268D17E7DF2E9E FOREIGN KEY (source_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE income_operation ADD CONSTRAINT FK_5E1A089912469DE2 FOREIGN KEY (category_id) REFERENCES income_category (id)');
        $this->addSql('ALTER TABLE income_operation ADD CONSTRAINT FK_5E1A089925A38F89 FOREIGN KEY (fund_id) REFERENCES fund (id)');
        $this->addSql('ALTER TABLE income_operation ADD CONSTRAINT FK_5E1A0899A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE income_operation ADD CONSTRAINT FK_5E1A0899A987872B FOREIGN KEY (target_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE income_operation ADD CONSTRAINT FK_5E1A0899BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE loan_operation ADD CONSTRAINT FK_58D29AF7217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE loan_operation ADD CONSTRAINT FK_58D29AF7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE loan_operation ADD CONSTRAINT FK_58D29AF7E7DF2E9E FOREIGN KEY (source_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE repayment_operation ADD CONSTRAINT FK_4604BFE7217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE repayment_operation ADD CONSTRAINT FK_4604BFE7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE repayment_operation ADD CONSTRAINT FK_4604BFE7E7DF2E9E FOREIGN KEY (source_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE transfer_operation ADD CONSTRAINT FK_B4079F06A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transfer_operation ADD CONSTRAINT FK_B4079F06A987872B FOREIGN KEY (target_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE transfer_operation ADD CONSTRAINT FK_B4079F06E7DF2E9E FOREIGN KEY (source_account_id) REFERENCES account (id)');
        $this->addSql('DROP TABLE operation_transfer');
        $this->addSql('DROP TABLE operation_debt');
        $this->addSql('DROP TABLE operation_debt_collection');
        $this->addSql('DROP TABLE operation_expense');
        $this->addSql('DROP TABLE operation_income');
        $this->addSql('DROP TABLE operation_loan');
        $this->addSql('DROP TABLE operation_repayment');
    }
}
