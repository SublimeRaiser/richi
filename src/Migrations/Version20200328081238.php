<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200328081238 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

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
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

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
    }
}
