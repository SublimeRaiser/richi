<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200313091719 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D12469DE2');
        $this->addSql('CREATE TABLE debt_collection_operation (id INT AUTO_INCREMENT NOT NULL, target_account_id INT DEFAULT NULL, person_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B70A9D53A987872B (target_account_id), INDEX IDX_B70A9D53217BBB47 (person_id), INDEX IDX_B70A9D53A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense_operation (id INT AUTO_INCREMENT NOT NULL, source_account_id INT DEFAULT NULL, category_id INT DEFAULT NULL, tag_id INT DEFAULT NULL, fund_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_DD268D17E7DF2E9E (source_account_id), INDEX IDX_DD268D1712469DE2 (category_id), INDEX IDX_DD268D17BAD26311 (tag_id), INDEX IDX_DD268D1725A38F89 (fund_id), INDEX IDX_DD268D17A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repayment_operation (id INT AUTO_INCREMENT NOT NULL, source_account_id INT DEFAULT NULL, person_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4604BFE7E7DF2E9E (source_account_id), INDEX IDX_4604BFE7217BBB47 (person_id), INDEX IDX_4604BFE7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE debt_operation (id INT AUTO_INCREMENT NOT NULL, target_account_id INT DEFAULT NULL, person_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6A13AC58A987872B (target_account_id), INDEX IDX_6A13AC58217BBB47 (person_id), INDEX IDX_6A13AC58A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE income_operation (id INT AUTO_INCREMENT NOT NULL, target_account_id INT DEFAULT NULL, category_id INT DEFAULT NULL, tag_id INT DEFAULT NULL, fund_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5E1A0899A987872B (target_account_id), INDEX IDX_5E1A089912469DE2 (category_id), INDEX IDX_5E1A0899BAD26311 (tag_id), INDEX IDX_5E1A089925A38F89 (fund_id), INDEX IDX_5E1A0899A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loan_operation (id INT AUTO_INCREMENT NOT NULL, source_account_id INT DEFAULT NULL, person_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_58D29AF7E7DF2E9E (source_account_id), INDEX IDX_58D29AF7217BBB47 (person_id), INDEX IDX_58D29AF7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transfer_operation (id INT AUTO_INCREMENT NOT NULL, source_account_id INT DEFAULT NULL, target_account_id INT DEFAULT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B4079F06E7DF2E9E (source_account_id), INDEX IDX_B4079F06A987872B (target_account_id), INDEX IDX_B4079F06A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE income_category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2F2D922F727ACA70 (parent_id), INDEX IDX_2F2D922FA76ED395 (user_id), UNIQUE INDEX income_category_uq (user_id, parent_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense_category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C02DDB38727ACA70 (parent_id), INDEX IDX_C02DDB38A76ED395 (user_id), UNIQUE INDEX expense_category_uq (user_id, parent_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE debt_collection_operation ADD CONSTRAINT FK_B70A9D53A987872B FOREIGN KEY (target_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE debt_collection_operation ADD CONSTRAINT FK_B70A9D53217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE debt_collection_operation ADD CONSTRAINT FK_B70A9D53A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE expense_operation ADD CONSTRAINT FK_DD268D17E7DF2E9E FOREIGN KEY (source_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE expense_operation ADD CONSTRAINT FK_DD268D1712469DE2 FOREIGN KEY (category_id) REFERENCES expense_category (id)');
        $this->addSql('ALTER TABLE expense_operation ADD CONSTRAINT FK_DD268D17BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE expense_operation ADD CONSTRAINT FK_DD268D1725A38F89 FOREIGN KEY (fund_id) REFERENCES fund (id)');
        $this->addSql('ALTER TABLE expense_operation ADD CONSTRAINT FK_DD268D17A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE repayment_operation ADD CONSTRAINT FK_4604BFE7E7DF2E9E FOREIGN KEY (source_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE repayment_operation ADD CONSTRAINT FK_4604BFE7217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE repayment_operation ADD CONSTRAINT FK_4604BFE7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE debt_operation ADD CONSTRAINT FK_6A13AC58A987872B FOREIGN KEY (target_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE debt_operation ADD CONSTRAINT FK_6A13AC58217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE debt_operation ADD CONSTRAINT FK_6A13AC58A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE income_operation ADD CONSTRAINT FK_5E1A0899A987872B FOREIGN KEY (target_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE income_operation ADD CONSTRAINT FK_5E1A089912469DE2 FOREIGN KEY (category_id) REFERENCES income_category (id)');
        $this->addSql('ALTER TABLE income_operation ADD CONSTRAINT FK_5E1A0899BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE income_operation ADD CONSTRAINT FK_5E1A089925A38F89 FOREIGN KEY (fund_id) REFERENCES fund (id)');
        $this->addSql('ALTER TABLE income_operation ADD CONSTRAINT FK_5E1A0899A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE loan_operation ADD CONSTRAINT FK_58D29AF7E7DF2E9E FOREIGN KEY (source_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE loan_operation ADD CONSTRAINT FK_58D29AF7217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE loan_operation ADD CONSTRAINT FK_58D29AF7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transfer_operation ADD CONSTRAINT FK_B4079F06E7DF2E9E FOREIGN KEY (source_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE transfer_operation ADD CONSTRAINT FK_B4079F06A987872B FOREIGN KEY (target_account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE transfer_operation ADD CONSTRAINT FK_B4079F06A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE income_category ADD CONSTRAINT FK_2F2D922F727ACA70 FOREIGN KEY (parent_id) REFERENCES income_category (id)');
        $this->addSql('ALTER TABLE income_category ADD CONSTRAINT FK_2F2D922FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE expense_category ADD CONSTRAINT FK_C02DDB38727ACA70 FOREIGN KEY (parent_id) REFERENCES expense_category (id)');
        $this->addSql('ALTER TABLE expense_category ADD CONSTRAINT FK_C02DDB38A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE operation');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE income_operation DROP FOREIGN KEY FK_5E1A089912469DE2');
        $this->addSql('ALTER TABLE income_category DROP FOREIGN KEY FK_2F2D922F727ACA70');
        $this->addSql('ALTER TABLE expense_operation DROP FOREIGN KEY FK_DD268D1712469DE2');
        $this->addSql('ALTER TABLE expense_category DROP FOREIGN KEY FK_C02DDB38727ACA70');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, operation_type SMALLINT NOT NULL, icon VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_64C19C1A76ED395 (user_id), INDEX IDX_64C19C1727ACA70 (parent_id), UNIQUE INDEX category_uq (user_id, parent_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, source_id INT DEFAULT NULL, target_id INT DEFAULT NULL, category_id INT DEFAULT NULL, person_id INT DEFAULT NULL, tag_id INT DEFAULT NULL, fund_id INT DEFAULT NULL, amount INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, type SMALLINT NOT NULL, INDEX IDX_1981A66D953C1C61 (source_id), INDEX IDX_1981A66D12469DE2 (category_id), INDEX IDX_1981A66DBAD26311 (tag_id), INDEX IDX_1981A66DA76ED395 (user_id), INDEX IDX_1981A66D158E0B66 (target_id), INDEX IDX_1981A66D217BBB47 (person_id), INDEX IDX_1981A66D25A38F89 (fund_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D158E0B66 FOREIGN KEY (target_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D25A38F89 FOREIGN KEY (fund_id) REFERENCES fund (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D953C1C61 FOREIGN KEY (source_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('DROP TABLE debt_collection_operation');
        $this->addSql('DROP TABLE expense_operation');
        $this->addSql('DROP TABLE repayment_operation');
        $this->addSql('DROP TABLE debt_operation');
        $this->addSql('DROP TABLE income_operation');
        $this->addSql('DROP TABLE loan_operation');
        $this->addSql('DROP TABLE transfer_operation');
        $this->addSql('DROP TABLE income_category');
        $this->addSql('DROP TABLE expense_category');
    }
}
