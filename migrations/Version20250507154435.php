<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250507154435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insertion des émotions primaires et secondaires liées avec descriptions et scores';
    }

    public function up(Schema $schema): void
    {
        // Émotions primaires
        $this->addSql("INSERT INTO primary_emotions (id, name, description) VALUES
            (1, 'Joie', 'Émotions positives de satisfaction ou bonheur'),
            (2, 'Colère', 'Réaction face à une injustice ou frustration'),
            (3, 'Peur', 'Réponse à un danger ou à une menace perçue'),
            (4, 'Tristesse', 'Réaction à une perte ou un échec'),
            (5, 'Surprise', 'Réaction face à l’inattendu'),
            (6, 'Dégout', 'Réaction de rejet envers quelque chose de perçu comme négatif')
        ;");

        // Émotions secondaires
        $this->addSql("INSERT INTO secondary_emotions (name, description, score, primary_emotion_id) VALUES
            ('Fierté', 'Satisfaction envers soi-même ou ses réussites', 2.0, 1),
            ('Contentement', 'Sensation calme de bien-être', 1.5, 1),
            ('Enchantement', 'Joie intense mêlée d’admiration', 2.5, 1),
            ('Excitation', 'Énergie vive et enthousiasme', 3.0, 1),
            ('Emerveillement', 'Étonnement joyeux et admiration', 2.8, 1),
            ('Gratitude', 'Reconnaissance sincère', 1.7, 1),

            ('Frustration', 'Blocage dans l’atteinte d’un objectif', -2.0, 2),
            ('Irritation', 'Agacement léger et répétitif', -1.5, 2),
            ('Rage', 'Colère explosive et intense', -3.0, 2),
            ('Ressentiment', 'Colère persistante tournée vers le passé', -2.5, 2),
            ('Agacement', 'Colère légère et passagère', -1.0, 2),
            ('Hostilité', 'Attitude agressive envers autrui', -2.8, 2),

            ('Inquiétude', 'Anticipation négative d’un problème', -1.5, 3),
            ('Anxiété', 'Tension intérieure chronique', -2.0, 3),
            ('Terreur', 'Peur paralysante', -3.0, 3),
            ('Apprehension', 'Peur anticipée d’un événement', -1.7, 3),
            ('Panique', 'Peur soudaine et désorganisée', -2.8, 3),
            ('Crainte', 'Méfiance et vigilance', -1.8, 3),

            ('Chagrin', 'Douleur émotionnelle liée à une perte', -2.5, 4),
            ('Mélancolie', 'Tristesse douce et persistante', -2.0, 4),
            ('Abattement', 'Perte d’énergie et d’espoir', -2.8, 4),
            ('Désespoir', 'Absence totale d’espoir', -3.0, 4),
            ('Solitude', 'Isolement affectif ou social', -2.0, 4),
            ('Dépression', 'État prolongé de tristesse profonde', -3.5, 4),

            ('Etonnement', 'Surprise neutre face à un événement', 0.5, 5),
            ('Stupéfaction', 'Surprise mêlée d’incompréhension', 0.2, 5),
            ('Sidération', 'Blocage face à un choc', -0.5, 5),
            ('Incrédule', 'Doute fort face à une information', -0.3, 5),
            ('Emerveillement', 'Surprise teintée de beauté', 2.0, 5),
            ('Confusion', 'Perte de repères', -1.0, 5),

            ('Répulsion', 'Rejet fort envers quelque chose', -2.5, 6),
            ('Déplaisir', 'Sensation désagréable', -1.5, 6),
            ('Nausée', 'Dégoût physique ou psychologique', -2.8, 6),
            ('Dédain', 'Mépris affiché', -2.2, 6),
            ('Horreur', 'Dégoût intense mêlé de peur', -3.0, 6),
            ('Dégoût profond', 'Rejet viscéral', -3.2, 6)
        ;");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM secondary_emotions;');
        $this->addSql('DELETE FROM primary_emotions;');
    }
}
