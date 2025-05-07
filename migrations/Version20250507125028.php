<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250507125028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert basic emergency informations and resource informations';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO `emergency_informations` (`name`, `description`, `content`, `emergency_phone_number`) VALUES 
            ('Urgence psychiatrie', 'Service 24h/24 pour crise psychiatrique', 'Appelez immédiatement si vous ou un proche êtes en crise psychotique ou suicidaire.', '0800 123 456'),
            ('Service d aide médicale urgente', 'Médical – SAMU', 'Contacter pour toute urgence médicale grave : douleurs intenses, AVC, hémorragie.', '15'),
            ('Police secours', 'Police et gendarmerie', 'Pour toute situation de danger imminent ou violences.', '17')
        ;");

        $this->addSql("INSERT INTO `informations_ressources` (`name`, `description`, `content`, `exercise_id`) VALUES 
            ('Techniques de relaxation', 'Étirements et respiration pour détendre le corps', '1. Asseyez-vous confortablement\n2. Inspirez profondément en levant les bras\n3. Expirez en relâchant les muscles…', NULL),
            ('Exercice de respiration', 'Respiration consciente pour gérer l\'anxiété', '– Placez une main sur votre ventre\n– Inspirez lentement par le nez\n– Expirez par la bouche', NULL),
            ('Guide de sommeil', 'Routines pour améliorer la qualité du sommeil', '1. Éteignez les écrans 1 h avant le coucher\n2. Adoptez une température fraîche\n3. Pratiquez la cohérence cardiaque…', NULL)
        ;");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM `informations_ressources` WHERE `name` IN (
            'Techniques de relaxation',
            'Exercice de respiration',
            'Guide de sommeil'
        );");

        $this->addSql("DELETE FROM `emergency_informations` WHERE `name` IN (
            'Urgence psychiatrie',
            'Service d aide médicale urgente',
            'Police secours'
        );");
    }
}
