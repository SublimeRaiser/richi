<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200406033404 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation_transfer CHANGE source_id source_id INT NOT NULL, CHANGE target_id target_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_debt CHANGE target_id target_id INT NOT NULL, CHANGE person_id person_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_debt_collection CHANGE target_id target_id INT NOT NULL, CHANGE person_id person_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_expense CHANGE category_id category_id INT NOT NULL, CHANGE source_id source_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_income CHANGE category_id category_id INT NOT NULL, CHANGE target_id target_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_loan CHANGE source_id source_id INT NOT NULL, CHANGE person_id person_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation_repayment CHANGE source_id source_id INT NOT NULL, CHANGE person_id person_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation_debt CHANGE target_id target_id INT DEFAULT NULL, CHANGE person_id person_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_debt_collection CHANGE target_id target_id INT DEFAULT NULL, CHANGE person_id person_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_expense CHANGE source_id source_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_income CHANGE target_id target_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_loan CHANGE source_id source_id INT DEFAULT NULL, CHANGE person_id person_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_repayment CHANGE source_id source_id INT DEFAULT NULL, CHANGE person_id person_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation_transfer CHANGE source_id source_id INT DEFAULT NULL, CHANGE target_id target_id INT DEFAULT NULL');
    }
}
