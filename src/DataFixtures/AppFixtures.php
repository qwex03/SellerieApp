<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Etat;
use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\Emplacement;
use App\Entity\Historique;
use App\Entity\Statuts;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture {

    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

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

        $etat = ['en attente', 'en cours', 'fini'];
        foreach ($etat as $e) {
            $newEtat = new Statuts();
            $newEtat->setEtat($e);
            $manager->persist($newEtat);
        }

        $produits = []; 
        for ($k = 0; $k < 300; $k++) { 
            $produit = new Produit();
            $produit->setNom($faker->word())
                    ->setIdEtat($faker->randomElement($etats)) 
                    ->setIdEmplacement($faker->randomElement($emplacements)) 
                    ->setIdCategorie($faker->randomElement($categories));

            $manager->persist($produit);
            $produits[] = $produit; 
        }

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            if ($i == 0) {
                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles([]);
            }

            $hash = $this->hasher->hashPassword($user, 'Root');
            $user->setPassword($hash);

            $manager->persist($user);
        }

        for ($i = 0; $i < 50; $i++) {
            $historique = new Historique();
            $dateRetour = new \DateTimeImmutable($faker->dateTimeBetween('now', '+20 days')->format('Y-m-d'));
            $historique->setDateRetour($dateRetour)
                    ->setNom($faker->name())
                    ->setProduit($faker->randomElement($produits)) 
                    ->setRetour($faker->boolean()); 

            $manager->persist($historique);
        }

        $manager->flush(); 
    }
}
