<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200817080156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, active TINYINT(1) NOT NULL, paid TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_fruit (cart_id INT NOT NULL, fruit_id INT NOT NULL, INDEX IDX_FFE1BF9F1AD5CDBF (cart_id), INDEX IDX_FFE1BF9FBAC115F0 (fruit_id), PRIMARY KEY(cart_id, fruit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_user (cart_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6276D6701AD5CDBF (cart_id), INDEX IDX_6276D670A76ED395 (user_id), PRIMARY KEY(cart_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart_fruit ADD CONSTRAINT FK_FFE1BF9F1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_fruit ADD CONSTRAINT FK_FFE1BF9FBAC115F0 FOREIGN KEY (fruit_id) REFERENCES fruit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_user ADD CONSTRAINT FK_6276D6701AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_user ADD CONSTRAINT FK_6276D670A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_fruit DROP FOREIGN KEY FK_FFE1BF9F1AD5CDBF');
        $this->addSql('ALTER TABLE cart_user DROP FOREIGN KEY FK_6276D6701AD5CDBF');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_fruit');
        $this->addSql('DROP TABLE cart_user');
    }
}
