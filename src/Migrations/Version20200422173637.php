<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200422173637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    /**
     * @param Schema $schema
     *
     * @throws DBALException
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE operation_debt_relief (id INT AUTO_INCREMENT NOT NULL, debt_id INT NOT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_56EFBA1E240326A5 (debt_id), INDEX IDX_56EFBA1EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation_loan_relief (id INT AUTO_INCREMENT NOT NULL, loan_id INT NOT NULL, user_id INT NOT NULL, `date` DATE NOT NULL, amount INT NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2FF8DAB4CE73868F (loan_id), INDEX IDX_2FF8DAB4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE operation_debt_relief ADD CONSTRAINT FK_56EFBA1E240326A5 FOREIGN KEY (debt_id) REFERENCES debt (id)');
        $this->addSql('ALTER TABLE operation_debt_relief ADD CONSTRAINT FK_56EFBA1EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation_loan_relief ADD CONSTRAINT FK_2FF8DAB4CE73868F FOREIGN KEY (loan_id) REFERENCES loan (id)');
        $this->addSql('ALTER TABLE operation_loan_relief ADD CONSTRAINT FK_2FF8DAB4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    /**
     * @param Schema $schema
     *
     * @throws DBALException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE operation_debt_relief');
        $this->addSql('DROP TABLE operation_loan_relief');
    }
}
