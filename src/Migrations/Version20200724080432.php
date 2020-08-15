<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200724080432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation_transfer DROP FOREIGN KEY FK_A542DC4DA76ED395');
        $this->addSql('DROP INDEX IDX_A542DC4DA76ED395 ON operation_transfer');
        $this->addSql('ALTER TABLE operation_transfer DROP user_id');
        $this->addSql('ALTER TABLE operation_debt DROP FOREIGN KEY FK_F4CF5712A76ED395');
        $this->addSql('DROP INDEX IDX_F4CF5712A76ED395 ON operation_debt');
        $this->addSql('ALTER TABLE operation_debt DROP user_id');
        $this->addSql('ALTER TABLE operation_debt_collection DROP FOREIGN KEY FK_2E0BA358A76ED395');
        $this->addSql('DROP INDEX IDX_2E0BA358A76ED395 ON operation_debt_collection');
        $this->addSql('ALTER TABLE operation_debt_collection DROP user_id');
        $this->addSql('ALTER TABLE operation_debt_relief DROP FOREIGN KEY FK_56EFBA1EA76ED395');
        $this->addSql('DROP INDEX IDX_56EFBA1EA76ED395 ON operation_debt_relief');
        $this->addSql('ALTER TABLE operation_debt_relief DROP user_id');
        $this->addSql('ALTER TABLE operation_loan DROP FOREIGN KEY FK_EAA35092A76ED395');
        $this->addSql('DROP INDEX IDX_EAA35092A76ED395 ON operation_loan');
        $this->addSql('ALTER TABLE operation_loan DROP user_id');
        $this->addSql('ALTER TABLE operation_repayment DROP FOREIGN KEY FK_C3FF83B3A76ED395');
        $this->addSql('DROP INDEX IDX_C3FF83B3A76ED395 ON operation_repayment');
        $this->addSql('ALTER TABLE operation_repayment DROP user_id');
        $this->addSql('ALTER TABLE operation_loan_relief DROP FOREIGN KEY FK_2FF8DAB4A76ED395');
        $this->addSql('DROP INDEX IDX_2FF8DAB4A76ED395 ON operation_loan_relief');
        $this->addSql('ALTER TABLE operation_loan_relief DROP user_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation_debt ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_debt ADD CONSTRAINT FK_F4CF5712A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F4CF5712A76ED395 ON operation_debt (user_id)');
        $this->addSql('ALTER TABLE operation_debt_collection ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_debt_collection ADD CONSTRAINT FK_2E0BA358A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2E0BA358A76ED395 ON operation_debt_collection (user_id)');
        $this->addSql('ALTER TABLE operation_debt_relief ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_debt_relief ADD CONSTRAINT FK_56EFBA1EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_56EFBA1EA76ED395 ON operation_debt_relief (user_id)');
        $this->addSql('ALTER TABLE operation_loan ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_loan ADD CONSTRAINT FK_EAA35092A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_EAA35092A76ED395 ON operation_loan (user_id)');
        $this->addSql('ALTER TABLE operation_loan_relief ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_loan_relief ADD CONSTRAINT FK_2FF8DAB4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2FF8DAB4A76ED395 ON operation_loan_relief (user_id)');
        $this->addSql('ALTER TABLE operation_repayment ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_repayment ADD CONSTRAINT FK_C3FF83B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C3FF83B3A76ED395 ON operation_repayment (user_id)');
        $this->addSql('ALTER TABLE operation_transfer ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_transfer ADD CONSTRAINT FK_A542DC4DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A542DC4DA76ED395 ON operation_transfer (user_id)');
    }
}
