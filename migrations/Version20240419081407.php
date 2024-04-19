<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419081407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE twoote_category (twoote_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(twoote_id, category_id))');
        $this->addSql('CREATE INDEX IDX_10A4FFF5F025C261 ON twoote_category (twoote_id)');
        $this->addSql('CREATE INDEX IDX_10A4FFF512469DE2 ON twoote_category (category_id)');
        $this->addSql('ALTER TABLE twoote_category ADD CONSTRAINT FK_10A4FFF5F025C261 FOREIGN KEY (twoote_id) REFERENCES twoote (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE twoote_category ADD CONSTRAINT FK_10A4FFF512469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_twoote DROP CONSTRAINT fk_332e5abdf025c261');
        $this->addSql('ALTER TABLE category_twoote DROP CONSTRAINT fk_332e5abd12469de2');
        $this->addSql('DROP TABLE category_twoote');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE category_twoote (twoote_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(twoote_id, category_id))');
        $this->addSql('CREATE INDEX idx_332e5abd12469de2 ON category_twoote (category_id)');
        $this->addSql('CREATE INDEX idx_332e5abdf025c261 ON category_twoote (twoote_id)');
        $this->addSql('ALTER TABLE category_twoote ADD CONSTRAINT fk_332e5abdf025c261 FOREIGN KEY (twoote_id) REFERENCES twoote (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_twoote ADD CONSTRAINT fk_332e5abd12469de2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE twoote_category DROP CONSTRAINT FK_10A4FFF5F025C261');
        $this->addSql('ALTER TABLE twoote_category DROP CONSTRAINT FK_10A4FFF512469DE2');
        $this->addSql('DROP TABLE twoote_category');
    }
}
