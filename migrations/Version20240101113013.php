<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240101113013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about ADD background_image_id INT DEFAULT NULL, ADD first_file_id INT DEFAULT NULL, ADD second_file_id INT DEFAULT NULL, DROP background_image, DROP first_file, DROP second_file');
        $this->addSql('ALTER TABLE about ADD CONSTRAINT FK_B5F422E3E6DA28AA FOREIGN KEY (background_image_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE about ADD CONSTRAINT FK_B5F422E380471590 FOREIGN KEY (first_file_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE about ADD CONSTRAINT FK_B5F422E38489F901 FOREIGN KEY (second_file_id) REFERENCES file (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B5F422E3E6DA28AA ON about (background_image_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B5F422E380471590 ON about (first_file_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B5F422E38489F901 ON about (second_file_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about DROP FOREIGN KEY FK_B5F422E3E6DA28AA');
        $this->addSql('ALTER TABLE about DROP FOREIGN KEY FK_B5F422E380471590');
        $this->addSql('ALTER TABLE about DROP FOREIGN KEY FK_B5F422E38489F901');
        $this->addSql('DROP INDEX UNIQ_B5F422E3E6DA28AA ON about');
        $this->addSql('DROP INDEX UNIQ_B5F422E380471590 ON about');
        $this->addSql('DROP INDEX UNIQ_B5F422E38489F901 ON about');
        $this->addSql('ALTER TABLE about ADD background_image VARCHAR(255) DEFAULT NULL, ADD first_file VARCHAR(255) DEFAULT NULL, ADD second_file VARCHAR(255) DEFAULT NULL, DROP background_image_id, DROP first_file_id, DROP second_file_id');
    }
}
