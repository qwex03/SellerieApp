<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture {

    public function load(ObjectManager $manager):void 
    {
        $faker = Factory::create('fr_FR');


        for($i=0; $i < mt_rand(5, 10); $i++) {
            $cat = new Categorie();
            $cat->setNomCategorie($faker->word());
            $manager->persist($cat);            
        }


        $manager->flush();
    }

}