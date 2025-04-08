<?php

namespace App\DataFixtures;

use App\Entity\DiagnosticSteps;
use App\Entity\ProblemType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DiagnosticStepsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $problemTypes = $manager->getRepository(ProblemType::class)->findAll();
        
        foreach ($problemTypes as $problemType) {
            // Première étape - Symptôme principal
            $mainStep = new DiagnosticSteps();
            $mainStep->setDescription($this->getMainSymptomDescription($problemType->getName()));
            $mainStep->setType('symptome');
            $mainStep->setOrdre(1);
            $mainStep->setProblemType($problemType);
            $manager->persist($mainStep);

            // Étapes de vérification
            $checkSteps = $this->getCheckSteps($problemType->getName());
            $previousStep = $mainStep;
            $ordre = 2;

            foreach ($checkSteps as $checkStep) {
                $step = new DiagnosticSteps();
                $step->setDescription($checkStep);
                $step->setType('check');
                $step->setOrdre($ordre);
                $step->setProblemType($problemType);
                $step->setParent($mainStep);
                $step->setNextStep($previousStep);
                $manager->persist($step);
                $previousStep = $step;
                $ordre++;
            }

            // Étapes d'action
            $actionSteps = $this->getActionSteps($problemType->getName());
            foreach ($actionSteps as $actionStep) {
                $step = new DiagnosticSteps();
                $step->setDescription($actionStep);
                $step->setType('action');
                $step->setOrdre($ordre);
                $step->setProblemType($problemType);
                $step->setParent($mainStep);
                $step->setNextStep($previousStep);
                $manager->persist($step);
                $previousStep = $step;
                $ordre++;
            }
        }

        $manager->flush();
    }

    private function getMainSymptomDescription(string $problemType): string
    {
        return "Identification du problème : " . $problemType;
    }

    private function getCheckSteps(string $problemType): array
    {
        $checks = [
            'LA MACHINE NE DEMARRE PAS' => [
                'Vérifier la connexion électrique',
                'Vérifier le fusible',
                'Vérifier le bouton d\'alimentation',
                'Vérifier les connexions internes'
            ],
            'PROGRAMMATEUR EN ERREUR (affiche ERR)' => [
                'Vérifier l\'affichage du code d\'erreur',
                'Vérifier les connexions du programmateur',
                'Vérifier la tension d\'alimentation',
                'Vérifier les capteurs connectés'
            ],
            'PROGRAMMATEUR ne s\'allume plus ou clignote' => [
                'Vérifier l\'alimentation électrique',
                'Vérifier le bouton d\'alimentation',
                'Vérifier les connexions du programmateur',
                'Vérifier l\'état du fusible'
            ],
            'PLUS DE CONSOMMATION D\'ANTICALCAIRE' => [
                'Vérifier le niveau d\'anticalcaire',
                'Vérifier le système de dosage',
                'Vérifier les connexions du système',
                'Vérifier l\'état du réservoir'
            ],
            'PAS DE PRESSION AU MANO (LA POMPE NE TOURNE PAS) ALORS QU\'ON APPUIE SUR LA GACHETTE' => [
                'Vérifier le manomètre',
                'Vérifier la pompe',
                'Vérifier les connexions électriques',
                'Vérifier l\'état du moteur'
            ],
            'IMPOSSIBLE DE MONTER EN PRESSION SORTIE DE POMPE (AU MANO) et le moteur tourne' => [
                'Vérifier le manomètre',
                'Vérifier les joints d\'étanchéité',
                'Vérifier l\'état de la pompe',
                'Vérifier les vannes'
            ],
            'PRESSION OK AU MANO MAIS PAS OU PEU DE SORTIE D\'EAU AUX ACCESSOIRES' => [
                'Vérifier les accessoires',
                'Vérifier les tuyaux',
                'Vérifier les filtres',
                'Vérifier les vannes'
            ],
            'PRESSION SACCADEE' => [
                'Vérifier le manomètre',
                'Vérifier la pompe',
                'Vérifier les vannes',
                'Vérifier les joints'
            ],
            'LA MACHINE NE CHAUFFE PLUS VOYANT VERT ALLUME' => [
                'Vérifier la résistance',
                'Vérifier le thermostat',
                'Vérifier les connexions électriques',
                'Vérifier l\'état du voyant'
            ],
            'LA MACHINE NE CHAUFFE PLUS VOYANT VERT RESTE ETEINT' => [
                'Vérifier le voyant',
                'Vérifier le thermostat',
                'Vérifier les connexions',
                'Vérifier la résistance'
            ],
            'LA MACHINE NE CHAUFFE PAS ASSEZ' => [
                'Vérifier la température',
                'Vérifier le thermostat',
                'Vérifier la résistance',
                'Vérifier les paramètres'
            ],
            'VOYANT VERT S\'ETEINT JUSQU\'A UNE TEMPERATURE RELATIVEMENT BASSE' => [
                'Vérifier le thermostat',
                'Vérifier la température',
                'Vérifier le voyant',
                'Vérifier les paramètres'
            ],
            'LA MACHINE MONTE TROP EN TEMPERATURE' => [
                'Vérifier le thermostat',
                'Vérifier la température',
                'Vérifier la résistance',
                'Vérifier les paramètres'
            ],
            'LA MACHINE FUME BEAUCOUP' => [
                'Vérifier la température',
                'Vérifier les joints',
                'Vérifier la résistance',
                'Vérifier l\'état général'
            ]
        ];

        return $checks[$problemType] ?? [
            'Vérifier l\'état général',
            'Vérifier les connexions',
            'Vérifier les composants principaux',
            'Vérifier les paramètres'
        ];
    }

    private function getActionSteps(string $problemType): array
    {
        $actions = [
            'LA MACHINE NE DEMARRE PAS' => [
                'Remplacer le fusible si nécessaire',
                'Réparer les connexions électriques',
                'Remplacer le bouton d\'alimentation',
                'Nettoyer les contacts'
            ],
            'PROGRAMMATEUR EN ERREUR (affiche ERR)' => [
                'Réinitialiser le programmateur',
                'Remplacer le programmateur si nécessaire',
                'Rétablir les connexions',
                'Mettre à jour le firmware'
            ],
            'PROGRAMMATEUR ne s\'allume plus ou clignote' => [
                'Remplacer le programmateur',
                'Réparer les connexions',
                'Remplacer le bouton d\'alimentation',
                'Nettoyer les contacts'
            ],
            'PLUS DE CONSOMMATION D\'ANTICALCAIRE' => [
                'Recharger l\'anticalcaire',
                'Remplacer le système de dosage',
                'Nettoyer le réservoir',
                'Vérifier les paramètres de dosage'
            ],
            'PAS DE PRESSION AU MANO (LA POMPE NE TOURNE PAS) ALORS QU\'ON APPUIE SUR LA GACHETTE' => [
                'Remplacer la pompe',
                'Réparer les connexions électriques',
                'Remplacer le manomètre',
                'Nettoyer les vannes'
            ],
            'IMPOSSIBLE DE MONTER EN PRESSION SORTIE DE POMPE (AU MANO) et le moteur tourne' => [
                'Remplacer les joints d\'étanchéité',
                'Remplacer la pompe',
                'Nettoyer les vannes',
                'Ajuster la pression'
            ],
            'PRESSION OK AU MANO MAIS PAS OU PEU DE SORTIE D\'EAU AUX ACCESSOIRES' => [
                'Nettoyer les accessoires',
                'Remplacer les tuyaux',
                'Nettoyer les filtres',
                'Ajuster les vannes'
            ],
            'PRESSION SACCADEE' => [
                'Remplacer le manomètre',
                'Remplacer la pompe',
                'Nettoyer les vannes',
                'Ajuster la pression'
            ],
            'LA MACHINE NE CHAUFFE PLUS VOYANT VERT ALLUME' => [
                'Remplacer la résistance',
                'Remplacer le thermostat',
                'Réparer les connexions',
                'Nettoyer les contacts'
            ],
            'LA MACHINE NE CHAUFFE PLUS VOYANT VERT RESTE ETEINT' => [
                'Remplacer le thermostat',
                'Remplacer la résistance',
                'Réparer les connexions',
                'Nettoyer les contacts'
            ],
            'LA MACHINE NE CHAUFFE PAS ASSEZ' => [
                'Ajuster le thermostat',
                'Remplacer la résistance',
                'Nettoyer les composants',
                'Mettre à jour les paramètres'
            ],
            'VOYANT VERT S\'ETEINT JUSQU\'A UNE TEMPERATURE RELATIVEMENT BASSE' => [
                'Remplacer le thermostat',
                'Ajuster les paramètres',
                'Nettoyer les composants',
                'Vérifier la calibration'
            ],
            'LA MACHINE MONTE TROP EN TEMPERATURE' => [
                'Remplacer le thermostat',
                'Ajuster les paramètres',
                'Nettoyer les composants',
                'Vérifier la ventilation'
            ],
            'LA MACHINE FUME BEAUCOUP' => [
                'Remplacer les joints',
                'Nettoyer les composants',
                'Ajuster la température',
                'Vérifier la ventilation'
            ]
        ];

        return $actions[$problemType] ?? [
            'Nettoyer les composants',
            'Remplacer les pièces usées',
            'Ajuster les paramètres',
            'Vérifier la calibration'
        ];
    }

    public function getDependencies(): array
    {
        return [
            AppFixtures::class,
        ];
    }
} 