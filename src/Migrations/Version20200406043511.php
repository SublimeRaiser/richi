<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200406043511 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation_debt DROP FOREIGN KEY FK_F4CF5712217BBB47');
        $this->addSql('DROP INDEX IDX_F4CF5712217BBB47 ON operation_debt');
        $this->addSql('ALTER TABLE operation_debt DROP person_id');
        $this->addSql('ALTER TABLE operation_debt_collection DROP FOREIGN KEY FK_2E0BA358217BBB47');
        $this->addSql('DROP INDEX IDX_2E0BA358217BBB47 ON operation_debt_collection');
        $this->addSql('ALTER TABLE operation_debt_collection DROP person_id');
        $this->addSql('ALTER TABLE operation_loan DROP FOREIGN KEY FK_EAA35092217BBB47');
        $this->addSql('DROP INDEX IDX_EAA35092217BBB47 ON operation_loan');
        $this->addSql('ALTER TABLE operation_loan DROP person_id');
        $this->addSql('ALTER TABLE operation_repayment DROP FOREIGN KEY FK_C3FF83B3217BBB47');
        $this->addSql('DROP INDEX IDX_C3FF83B3217BBB47 ON operation_repayment');
        $this->addSql('ALTER TABLE operation_repayment DROP person_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation_debt ADD person_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_debt ADD CONSTRAINT FK_F4CF5712217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_F4CF5712217BBB47 ON operation_debt (person_id)');
        $this->addSql('ALTER TABLE operation_debt_collection ADD person_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_debt_collection ADD CONSTRAINT FK_2E0BA358217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_2E0BA358217BBB47 ON operation_debt_collection (person_id)');
        $this->addSql('ALTER TABLE operation_loan ADD person_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_loan ADD CONSTRAINT FK_EAA35092217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_EAA35092217BBB47 ON operation_loan (person_id)');
        $this->addSql('ALTER TABLE operation_repayment ADD person_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_repayment ADD CONSTRAINT FK_C3FF83B3217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('CREATE INDEX IDX_C3FF83B3217BBB47 ON operation_repayment (person_id)');
    }
}
