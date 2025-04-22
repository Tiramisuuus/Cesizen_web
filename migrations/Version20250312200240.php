<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250312200240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emergency_informations (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, content VARCHAR(2550) DEFAULT NULL, emergency_phone_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emotion_tracker (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, score DOUBLE PRECISION DEFAULT NULL, advice_given VARCHAR(2550) NOT NULL, INDEX IDX_B15F0BD09D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emotion_tracker_secondary_emotions (emotion_tracker_id INT NOT NULL, secondary_emotions_id INT NOT NULL, INDEX IDX_589CE466F3E8651F (emotion_tracker_id), INDEX IDX_589CE4661C925308 (secondary_emotions_id), PRIMARY KEY(emotion_tracker_id, secondary_emotions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercises (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, creation_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercises_stress_diagnostic_result (exercises_id INT NOT NULL, stress_diagnostic_result_id INT NOT NULL, INDEX IDX_91F6A5391AFA70CA (exercises_id), INDEX IDX_91F6A5393936D9E7 (stress_diagnostic_result_id), PRIMARY KEY(exercises_id, stress_diagnostic_result_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE informations_ressources (id INT AUTO_INCREMENT NOT NULL, exercice_id_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, content VARCHAR(2550) DEFAULT NULL, INDEX IDX_6D83030C26C958BE (exercice_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE primary_emotions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relaxation_exercises (id INT AUTO_INCREMENT NOT NULL, position VARCHAR(255) DEFAULT NULL, audio_file LONGBLOB DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE respiration_exercises (id INT AUTO_INCREMENT NOT NULL, inspiration_duration DOUBLE PRECISION DEFAULT NULL, apnea_duration DOUBLE PRECISION DEFAULT NULL, air_exhalation_duration DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secondary_emotions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, score DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stress_diagnostic (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date_realisation DATETIME NOT NULL, score DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_F5689BFE9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stress_diagnostic_result (id INT AUTO_INCREMENT NOT NULL, one_to_one_id INT DEFAULT NULL, description_result VARCHAR(2550) DEFAULT NULL, recommandations VARCHAR(2550) DEFAULT NULL, date_realisation DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B1435B8DB549C760 (one_to_one_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, name VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_emergency_informations (user_id INT NOT NULL, emergency_informations_id INT NOT NULL, INDEX IDX_60AEEF4AA76ED395 (user_id), INDEX IDX_60AEEF4AFF6E6202 (emergency_informations_id), PRIMARY KEY(user_id, emergency_informations_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_informations_ressources (user_id INT NOT NULL, informations_ressources_id INT NOT NULL, INDEX IDX_D452AA5DA76ED395 (user_id), INDEX IDX_D452AA5D30C7BD60 (informations_ressources_id), PRIMARY KEY(user_id, informations_ressources_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emotion_tracker ADD CONSTRAINT FK_B15F0BD09D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE emotion_tracker_secondary_emotions ADD CONSTRAINT FK_589CE466F3E8651F FOREIGN KEY (emotion_tracker_id) REFERENCES emotion_tracker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emotion_tracker_secondary_emotions ADD CONSTRAINT FK_589CE4661C925308 FOREIGN KEY (secondary_emotions_id) REFERENCES secondary_emotions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercises_stress_diagnostic_result ADD CONSTRAINT FK_91F6A5391AFA70CA FOREIGN KEY (exercises_id) REFERENCES exercises (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercises_stress_diagnostic_result ADD CONSTRAINT FK_91F6A5393936D9E7 FOREIGN KEY (stress_diagnostic_result_id) REFERENCES stress_diagnostic_result (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE informations_ressources ADD CONSTRAINT FK_6D83030C26C958BE FOREIGN KEY (exercice_id_id) REFERENCES exercises (id)');
        $this->addSql('ALTER TABLE stress_diagnostic ADD CONSTRAINT FK_F5689BFE9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stress_diagnostic_result ADD CONSTRAINT FK_B1435B8DB549C760 FOREIGN KEY (one_to_one_id) REFERENCES stress_diagnostic (id)');
        $this->addSql('ALTER TABLE user_emergency_informations ADD CONSTRAINT FK_60AEEF4AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_emergency_informations ADD CONSTRAINT FK_60AEEF4AFF6E6202 FOREIGN KEY (emergency_informations_id) REFERENCES emergency_informations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_informations_ressources ADD CONSTRAINT FK_D452AA5DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_informations_ressources ADD CONSTRAINT FK_D452AA5D30C7BD60 FOREIGN KEY (informations_ressources_id) REFERENCES informations_ressources (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emotion_tracker DROP FOREIGN KEY FK_B15F0BD09D86650F');
        $this->addSql('ALTER TABLE emotion_tracker_secondary_emotions DROP FOREIGN KEY FK_589CE466F3E8651F');
        $this->addSql('ALTER TABLE emotion_tracker_secondary_emotions DROP FOREIGN KEY FK_589CE4661C925308');
        $this->addSql('ALTER TABLE exercises_stress_diagnostic_result DROP FOREIGN KEY FK_91F6A5391AFA70CA');
        $this->addSql('ALTER TABLE exercises_stress_diagnostic_result DROP FOREIGN KEY FK_91F6A5393936D9E7');
        $this->addSql('ALTER TABLE informations_ressources DROP FOREIGN KEY FK_6D83030C26C958BE');
        $this->addSql('ALTER TABLE stress_diagnostic DROP FOREIGN KEY FK_F5689BFE9D86650F');
        $this->addSql('ALTER TABLE stress_diagnostic_result DROP FOREIGN KEY FK_B1435B8DB549C760');
        $this->addSql('ALTER TABLE user_emergency_informations DROP FOREIGN KEY FK_60AEEF4AA76ED395');
        $this->addSql('ALTER TABLE user_emergency_informations DROP FOREIGN KEY FK_60AEEF4AFF6E6202');
        $this->addSql('ALTER TABLE user_informations_ressources DROP FOREIGN KEY FK_D452AA5DA76ED395');
        $this->addSql('ALTER TABLE user_informations_ressources DROP FOREIGN KEY FK_D452AA5D30C7BD60');
        $this->addSql('DROP TABLE emergency_informations');
        $this->addSql('DROP TABLE emotion_tracker');
        $this->addSql('DROP TABLE emotion_tracker_secondary_emotions');
        $this->addSql('DROP TABLE exercises');
        $this->addSql('DROP TABLE exercises_stress_diagnostic_result');
        $this->addSql('DROP TABLE informations_ressources');
        $this->addSql('DROP TABLE primary_emotions');
        $this->addSql('DROP TABLE relaxation_exercises');
        $this->addSql('DROP TABLE respiration_exercises');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE secondary_emotions');
        $this->addSql('DROP TABLE stress_diagnostic');
        $this->addSql('DROP TABLE stress_diagnostic_result');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_emergency_informations');
        $this->addSql('DROP TABLE user_informations_ressources');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
