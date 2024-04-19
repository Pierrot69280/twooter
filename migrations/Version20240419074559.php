<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419074559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_twoote (twoote_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(twoote_id, category_id))');
        $this->addSql('CREATE INDEX IDX_332E5ABDF025C261 ON category_twoote (twoote_id)');
        $this->addSql('CREATE INDEX IDX_332E5ABD12469DE2 ON category_twoote (category_id)');
        $this->addSql('ALTER TABLE category_twoote ADD CONSTRAINT FK_332E5ABDF025C261 FOREIGN KEY (twoote_id) REFERENCES twoote (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_twoote ADD CONSTRAINT FK_332E5ABD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE twoote DROP CONSTRAINT fk_3cc690c612469de2');
        $this->addSql('DROP INDEX idx_3cc690c612469de2');
        $this->addSql('ALTER TABLE twoote DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE category_twoote DROP CONSTRAINT FK_332E5ABDF025C261');
        $this->addSql('ALTER TABLE category_twoote DROP CONSTRAINT FK_332E5ABD12469DE2');
        $this->addSql('DROP TABLE category_twoote');
        $this->addSql('ALTER TABLE twoote ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE twoote ADD CONSTRAINT fk_3cc690c612469de2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3cc690c612469de2 ON twoote (category_id)');
    }
}
