<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Etat;
use App\Entity\Categorie;
use App\Entity\Emplacement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture {

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $categories = [];
        for ($i = 0; $i < mt_rand(5, 10); $i++) {
            $cat = new Categorie();
            $cat->setNomCategorie($faker->word());
            $manager->persist($cat);
            $categories[] = $cat; 
        }

        $emplacements = [];
        for ($j = 0; $j < mt_rand(10, 30); $j++) {
            $emp = new Emplacement();
            $emp->setEtagere($faker->word())
                ->setRayon($faker->countryCode());
            $manager->persist($emp);
            $emplacements[] = $emp; 
        }

        $etats = [];
        $nomsEtats = ['neuf', 'bon état', 'usé', 'hors d\'usage', 'à réparer'];
        foreach ($nomsEtats as $etatNom) {
            $etat = new Etat();
            $etat->setNom($etatNom);
            $manager->persist($etat);
            $etats[] = $etat; 
        }

        for ($k = 0; $k < 300; $k++) { 
            $produit = new Produit();
            $produit->setNom($faker->word())
                    ->setIdEtat($faker->randomElement($etats)) 
                    ->setIdEmplacement($faker->randomElement($emplacements)) 
                    ->setIdCategorie($faker->randomElement($categories));

            $manager->persist($produit); 
        }

        $manager->flush(); 
    }
}
