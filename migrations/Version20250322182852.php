<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250322182852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, assistant_id INT NOT NULL, veterinarian_id INT DEFAULT NULL, created_date DATETIME NOT NULL, appointment_date DATETIME NOT NULL, reason LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, is_paid TINYINT(1) NOT NULL, INDEX IDX_FE38F8448E962C16 (animal_id), INDEX IDX_FE38F844E05387EF (assistant_id), INDEX IDX_FE38F844804C8213 (veterinarian_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appointment_treatment (appointment_id INT NOT NULL, treatment_id INT NOT NULL, INDEX IDX_D8B5238E5B533F9 (appointment_id), INDEX IDX_D8B5238471C0366 (treatment_id), PRIMARY KEY(appointment_id, treatment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8448E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844E05387EF FOREIGN KEY (assistant_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844804C8213 FOREIGN KEY (veterinarian_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE appointment_treatment ADD CONSTRAINT FK_D8B5238E5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointment_treatment ADD CONSTRAINT FK_D8B5238471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apointement DROP FOREIGN KEY FK_7144DD228E962C16');
        $this->addSql('ALTER TABLE apointement DROP FOREIGN KEY FK_7144DD22E05387EF');
        $this->addSql('ALTER TABLE apointement DROP FOREIGN KEY FK_7144DD22804C8213');
        $this->addSql('ALTER TABLE apointement_treatment DROP FOREIGN KEY FK_9CB5FF2718AF6914');
        $this->addSql('ALTER TABLE apointement_treatment DROP FOREIGN KEY FK_9CB5FF27471C0366');
        $this->addSql('DROP TABLE apointement');
        $this->addSql('DROP TABLE apointement_treatment');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apointement (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, assistant_id INT NOT NULL, veterinarian_id INT DEFAULT NULL, created_date DATETIME NOT NULL, apointement_date DATETIME NOT NULL, reason LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_paid TINYINT(1) NOT NULL, INDEX IDX_7144DD228E962C16 (animal_id), INDEX IDX_7144DD22E05387EF (assistant_id), INDEX IDX_7144DD22804C8213 (veterinarian_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE apointement_treatment (apointement_id INT NOT NULL, treatment_id INT NOT NULL, INDEX IDX_9CB5FF27471C0366 (treatment_id), INDEX IDX_9CB5FF2718AF6914 (apointement_id), PRIMARY KEY(apointement_id, treatment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE apointement ADD CONSTRAINT FK_7144DD228E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE apointement ADD CONSTRAINT FK_7144DD22E05387EF FOREIGN KEY (assistant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE apointement ADD CONSTRAINT FK_7144DD22804C8213 FOREIGN KEY (veterinarian_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE apointement_treatment ADD CONSTRAINT FK_9CB5FF2718AF6914 FOREIGN KEY (apointement_id) REFERENCES apointement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apointement_treatment ADD CONSTRAINT FK_9CB5FF27471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8448E962C16');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844E05387EF');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844804C8213');
        $this->addSql('ALTER TABLE appointment_treatment DROP FOREIGN KEY FK_D8B5238E5B533F9');
        $this->addSql('ALTER TABLE appointment_treatment DROP FOREIGN KEY FK_D8B5238471C0366');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE appointment_treatment');
    }
}
