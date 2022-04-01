<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220401085553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product DROP INDEX UNIQ_D34A04AD12469DE2, ADD INDEX IDX_D34A04AD12469DE2 (category_id)');
        $this->addSql('ALTER TABLE product ADD created_at DATETIME DEFAULT NULL, ADD update_at DATETIME DEFAULT NULL, ADD image2 VARCHAR(255) DEFAULT NULL, ADD image3 VARCHAR(255) DEFAULT NULL, ADD image4 VARCHAR(255) DEFAULT NULL, ADD image5 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD phone INT DEFAULT NULL, ADD surname VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(500) DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP slug');
        $this->addSql('ALTER TABLE product DROP INDEX IDX_D34A04AD12469DE2, ADD UNIQUE INDEX UNIQ_D34A04AD12469DE2 (category_id)');
        $this->addSql('ALTER TABLE product DROP created_at, DROP update_at, DROP image2, DROP image3, DROP image4, DROP image5');
        $this->addSql('ALTER TABLE `user` DROP phone, DROP surname, DROP address, DROP created_at');
    }
}
