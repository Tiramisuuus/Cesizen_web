<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250510100456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emotion_tracker ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE secondary_emotions ADD CONSTRAINT FK_4ECE296E204049E4 FOREIGN KEY (primary_emotion_id) REFERENCES primary_emotions (id)');
        $this->addSql('CREATE INDEX IDX_4ECE296E204049E4 ON secondary_emotions (primary_emotion_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emotion_tracker DROP created_at');
        $this->addSql('ALTER TABLE secondary_emotions DROP FOREIGN KEY FK_4ECE296E204049E4');
        $this->addSql('DROP INDEX IDX_4ECE296E204049E4 ON secondary_emotions');
    }
}
