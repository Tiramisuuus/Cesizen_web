<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250507132910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE informations_ressources ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE informations_ressources ADD CONSTRAINT FK_6D83030CF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_6D83030CF675F31B ON informations_ressources (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE informations_ressources DROP FOREIGN KEY FK_6D83030CF675F31B');
        $this->addSql('DROP INDEX IDX_6D83030CF675F31B ON informations_ressources');
        $this->addSql('ALTER TABLE informations_ressources DROP author_id');
    }
}
