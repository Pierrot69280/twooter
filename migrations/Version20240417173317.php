<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417173317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT fk_ac6340b3f2a47145');
        $this->addSql('DROP INDEX idx_ac6340b3f2a47145');
        $this->addSql('ALTER TABLE "like" DROP reply_comment_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "like" ADD reply_comment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT fk_ac6340b3f2a47145 FOREIGN KEY (reply_comment_id) REFERENCES reply_comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_ac6340b3f2a47145 ON "like" (reply_comment_id)');
    }
}
