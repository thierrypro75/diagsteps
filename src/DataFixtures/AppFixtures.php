<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\ProblemType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création des catégories
        $categories = [
            'PROBLEME DE FONCTIONNEMENT GENERAL' => [
                'LA MACHINE NE DEMARRE PAS',
                'PROGRAMMATEUR EN ERREUR (affiche ERR)',
                'PROGRAMMATEUR ne s\'allume plus ou clignote',
                'PLUS DE CONSOMMATION D\'ANTICALCAIRE'
            ],
            'PROBLEME DE PRESSION' => [
                'PAS DE PRESSION AU MANO (LA POMPE NE TOURNE PAS) ALORS QU\'ON APPUIE SUR LA GACHETTE',
                'IMPOSSIBLE DE MONTER EN PRESSION SORTIE DE POMPE (AU MANO) et le moteur tourne',
                'PRESSION OK AU MANO MAIS PAS OU PEU DE SORTIE D\'EAU AUX ACCESSOIRES',
                'PRESSION SACCADEE'
            ],
            'PROBLEME DE CHAUFFE' => [
                'LA MACHINE NE CHAUFFE PLUS VOYANT VERT ALLUME',
                'LA MACHINE NE CHAUFFE PLUS VOYANT VERT RESTE ETEINT',
                'LA MACHINE NE CHAUFFE PAS ASSEZ',
                'VOYANT VERT S\'ETEINT JUSQU\'A UNE TEMPERATURE RELATIVEMENT BASSE',
                'LA MACHINE MONTE TROP EN TEMPERATURE',
                'LA MACHINE FUME BEAUCOUP'
            ]
        ];

        foreach ($categories as $categoryName => $problemTypes) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);

            foreach ($problemTypes as $problemTypeName) {
                $problemType = new ProblemType();
                $problemType->setName($problemTypeName);
                $problemType->setCategory($category);
                $manager->persist($problemType);
            }
        }

        $manager->flush();
    }
}
