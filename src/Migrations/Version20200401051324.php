<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200401051324 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation_debt DROP FOREIGN KEY FK_F4CF57129B6B5FBA');
        $this->addSql('DROP INDEX IDX_F4CF57129B6B5FBA ON operation_debt');
        $this->addSql('ALTER TABLE operation_debt CHANGE account_id target_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_debt ADD CONSTRAINT FK_F4CF5712158E0B66 FOREIGN KEY (target_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_F4CF5712158E0B66 ON operation_debt (target_id)');
        $this->addSql('ALTER TABLE operation_debt_collection DROP FOREIGN KEY FK_2E0BA3589B6B5FBA');
        $this->addSql('DROP INDEX IDX_2E0BA3589B6B5FBA ON operation_debt_collection');
        $this->addSql('ALTER TABLE operation_debt_collection CHANGE account_id target_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_debt_collection ADD CONSTRAINT FK_2E0BA358158E0B66 FOREIGN KEY (target_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_2E0BA358158E0B66 ON operation_debt_collection (target_id)');
        $this->addSql('ALTER TABLE operation_expense DROP FOREIGN KEY FK_8EFB0D6B9B6B5FBA');
        $this->addSql('DROP INDEX IDX_8EFB0D6B9B6B5FBA ON operation_expense');
        $this->addSql('ALTER TABLE operation_expense CHANGE account_id source_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_expense ADD CONSTRAINT FK_8EFB0D6B953C1C61 FOREIGN KEY (source_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_8EFB0D6B953C1C61 ON operation_expense (source_id)');
        $this->addSql('ALTER TABLE operation_income DROP FOREIGN KEY FK_4228DBB29B6B5FBA');
        $this->addSql('DROP INDEX IDX_4228DBB29B6B5FBA ON operation_income');
        $this->addSql('ALTER TABLE operation_income CHANGE account_id target_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_income ADD CONSTRAINT FK_4228DBB2158E0B66 FOREIGN KEY (target_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_4228DBB2158E0B66 ON operation_income (target_id)');
        $this->addSql('ALTER TABLE operation_loan DROP FOREIGN KEY FK_EAA350929B6B5FBA');
        $this->addSql('DROP INDEX IDX_EAA350929B6B5FBA ON operation_loan');
        $this->addSql('ALTER TABLE operation_loan CHANGE account_id source_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_loan ADD CONSTRAINT FK_EAA35092953C1C61 FOREIGN KEY (source_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_EAA35092953C1C61 ON operation_loan (source_id)');
        $this->addSql('ALTER TABLE operation_repayment DROP FOREIGN KEY FK_C3FF83B39B6B5FBA');
        $this->addSql('DROP INDEX IDX_C3FF83B39B6B5FBA ON operation_repayment');
        $this->addSql('ALTER TABLE operation_repayment CHANGE account_id source_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_repayment ADD CONSTRAINT FK_C3FF83B3953C1C61 FOREIGN KEY (source_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_C3FF83B3953C1C61 ON operation_repayment (source_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation_debt DROP FOREIGN KEY FK_F4CF5712158E0B66');
        $this->addSql('DROP INDEX IDX_F4CF5712158E0B66 ON operation_debt');
        $this->addSql('ALTER TABLE operation_debt CHANGE target_id account_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_debt ADD CONSTRAINT FK_F4CF57129B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_F4CF57129B6B5FBA ON operation_debt (account_id)');
        $this->addSql('ALTER TABLE operation_debt_collection DROP FOREIGN KEY FK_2E0BA358158E0B66');
        $this->addSql('DROP INDEX IDX_2E0BA358158E0B66 ON operation_debt_collection');
        $this->addSql('ALTER TABLE operation_debt_collection CHANGE target_id account_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_debt_collection ADD CONSTRAINT FK_2E0BA3589B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_2E0BA3589B6B5FBA ON operation_debt_collection (account_id)');
        $this->addSql('ALTER TABLE operation_expense DROP FOREIGN KEY FK_8EFB0D6B953C1C61');
        $this->addSql('DROP INDEX IDX_8EFB0D6B953C1C61 ON operation_expense');
        $this->addSql('ALTER TABLE operation_expense CHANGE source_id account_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_expense ADD CONSTRAINT FK_8EFB0D6B9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_8EFB0D6B9B6B5FBA ON operation_expense (account_id)');
        $this->addSql('ALTER TABLE operation_income DROP FOREIGN KEY FK_4228DBB2158E0B66');
        $this->addSql('DROP INDEX IDX_4228DBB2158E0B66 ON operation_income');
        $this->addSql('ALTER TABLE operation_income CHANGE target_id account_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_income ADD CONSTRAINT FK_4228DBB29B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_4228DBB29B6B5FBA ON operation_income (account_id)');
        $this->addSql('ALTER TABLE operation_loan DROP FOREIGN KEY FK_EAA35092953C1C61');
        $this->addSql('DROP INDEX IDX_EAA35092953C1C61 ON operation_loan');
        $this->addSql('ALTER TABLE operation_loan CHANGE source_id account_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_loan ADD CONSTRAINT FK_EAA350929B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_EAA350929B6B5FBA ON operation_loan (account_id)');
        $this->addSql('ALTER TABLE operation_repayment DROP FOREIGN KEY FK_C3FF83B3953C1C61');
        $this->addSql('DROP INDEX IDX_C3FF83B3953C1C61 ON operation_repayment');
        $this->addSql('ALTER TABLE operation_repayment CHANGE source_id account_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_repayment ADD CONSTRAINT FK_C3FF83B39B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_C3FF83B39B6B5FBA ON operation_repayment (account_id)');
    }
}
