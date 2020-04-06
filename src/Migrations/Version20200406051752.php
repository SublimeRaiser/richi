<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200406051752 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation_debt ADD debt_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_debt ADD CONSTRAINT FK_F4CF5712240326A5 FOREIGN KEY (debt_id) REFERENCES debt (id)');
        $this->addSql('CREATE INDEX IDX_F4CF5712240326A5 ON operation_debt (debt_id)');
        $this->addSql('ALTER TABLE operation_debt_collection ADD loan_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_debt_collection ADD CONSTRAINT FK_2E0BA358CE73868F FOREIGN KEY (loan_id) REFERENCES loan (id)');
        $this->addSql('CREATE INDEX IDX_2E0BA358CE73868F ON operation_debt_collection (loan_id)');
        $this->addSql('ALTER TABLE operation_loan ADD loan_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_loan ADD CONSTRAINT FK_EAA35092CE73868F FOREIGN KEY (loan_id) REFERENCES loan (id)');
        $this->addSql('CREATE INDEX IDX_EAA35092CE73868F ON operation_loan (loan_id)');
        $this->addSql('ALTER TABLE operation_repayment ADD debt_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_repayment ADD CONSTRAINT FK_C3FF83B3240326A5 FOREIGN KEY (debt_id) REFERENCES debt (id)');
        $this->addSql('CREATE INDEX IDX_C3FF83B3240326A5 ON operation_repayment (debt_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation_debt DROP FOREIGN KEY FK_F4CF5712240326A5');
        $this->addSql('DROP INDEX IDX_F4CF5712240326A5 ON operation_debt');
        $this->addSql('ALTER TABLE operation_debt DROP debt_id');
        $this->addSql('ALTER TABLE operation_debt_collection DROP FOREIGN KEY FK_2E0BA358CE73868F');
        $this->addSql('DROP INDEX IDX_2E0BA358CE73868F ON operation_debt_collection');
        $this->addSql('ALTER TABLE operation_debt_collection DROP loan_id');
        $this->addSql('ALTER TABLE operation_loan DROP FOREIGN KEY FK_EAA35092CE73868F');
        $this->addSql('DROP INDEX IDX_EAA35092CE73868F ON operation_loan');
        $this->addSql('ALTER TABLE operation_loan DROP loan_id');
        $this->addSql('ALTER TABLE operation_repayment DROP FOREIGN KEY FK_C3FF83B3240326A5');
        $this->addSql('DROP INDEX IDX_C3FF83B3240326A5 ON operation_repayment');
        $this->addSql('ALTER TABLE operation_repayment DROP debt_id');
    }
}
