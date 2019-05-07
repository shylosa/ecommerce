<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190507175842 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F098C26A5E8');
        $this->addSql('CREATE TABLE \'orderNumber\' (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_create DATETIME NOT NULL, state VARCHAR(255) NOT NULL, order_price INT DEFAULT NULL, payment_state TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_54355C9EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE \'orderNumber\' ADD CONSTRAINT FK_54355C9EA76ED395 FOREIGN KEY (user_id) REFERENCES site_user (id)');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F098C26A5E8');
        $this->addSql('ALTER TABLE order_item ADD product_id INT NOT NULL, DROP product');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098C26A5E8 FOREIGN KEY (order_number_id) REFERENCES \'orderNumber\' (id)');
        $this->addSql('CREATE INDEX IDX_52EA1F094584665A ON order_item (product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F098C26A5E8');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_create DATETIME NOT NULL, state VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, order_price INT DEFAULT NULL, payment_state TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES site_user (id)');
        $this->addSql('DROP TABLE \'orderNumber\'');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F094584665A');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F098C26A5E8');
        $this->addSql('DROP INDEX IDX_52EA1F094584665A ON order_item');
        $this->addSql('ALTER TABLE order_item ADD product VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP product_id');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098C26A5E8 FOREIGN KEY (order_number_id) REFERENCES `order` (id)');
    }
}
