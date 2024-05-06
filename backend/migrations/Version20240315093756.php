<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240315093756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subscription (subscription_id INT AUTO_INCREMENT NOT NULL, subscription_user_id INT DEFAULT NULL, subscription_product_name VARCHAR(255) NOT NULL, subscription_period_start DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', subscription_period_end DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', subscription_notice_period INT NOT NULL, subscription_notice_period_type VARCHAR(255) NOT NULL, subscription_period_renewal_in_months INT NOT NULL, subscription_canceled_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', subscription_created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', subscription_updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A3C664D3D47B330E (subscription_user_id), PRIMARY KEY(subscription_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (user_id INT AUTO_INCREMENT NOT NULL, user_email VARCHAR(255) NOT NULL, user_created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', user_updated DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3D47B330E FOREIGN KEY (subscription_user_id) REFERENCES user (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3D47B330E');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE user');
    }
}
