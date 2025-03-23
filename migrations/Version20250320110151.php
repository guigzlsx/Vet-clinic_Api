<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250320110151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, assistant_id INT NOT NULL, veterinarian_id INT NOT NULL, created_date DATETIME NOT NULL, appointment_date DATETIME NOT NULL, reason LONGTEXT NOT NULL, status JSON NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_7144DD228E962C16 (animal_id), INDEX IDX_7144DD22E05387EF (assistant_id), INDEX IDX_7144DD22804C8213 (veterinarian_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appointment_treatment (appointment_id INT NOT NULL, treatment_id INT NOT NULL, INDEX IDX_9CB5FF2718AF6914 (appointment_id), INDEX IDX_9CB5FF27471C0366 (treatment_id), PRIMARY KEY(appointment_id, treatment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_7144DD228E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_7144DD22E05387EF FOREIGN KEY (assistant_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_7144DD22804C8213 FOREIGN KEY (veterinarian_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE appointment_treatment ADD CONSTRAINT FK_9CB5FF2718AF6914 FOREIGN KEY (appointment_id) REFERENCES appointment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointment_treatment ADD CONSTRAINT FK_9CB5FF27471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_7144DD228E962C16');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_7144DD22E05387EF');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_7144DD22804C8213');
        $this->addSql('ALTER TABLE appointment_treatment DROP FOREIGN KEY FK_9CB5FF2718AF6914');
        $this->addSql('ALTER TABLE appointment_treatment DROP FOREIGN KEY FK_9CB5FF27471C0366');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE appointment_treatment');
    }
}
