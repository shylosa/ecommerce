<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190513170037 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE orderNumber');
        $this->addSql('ALTER TABLE product ADD image_name VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE orderNumber (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_create DATETIME NOT NULL, state VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, order_price INT DEFAULT NULL, payment_state TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_989A8203A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE orderNumber ADD CONSTRAINT FK_989A8203A76ED395 FOREIGN KEY (user_id) REFERENCES site_user (id)');
        $this->addSql('ALTER TABLE product DROP image_name, DROP updated_at');
    }
}
