<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Book;
use App\Entity\Categories;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

class LivreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr-FR');
        for ($j = 1; $j <= 3; $j++) {
            $cat = new Categories();
            $cat->setLibelle($faker->name());
            $cat->setDescription($faker->text());
            $manager->persist($cat);


            for ($i = 1; $i <= rand(5, 15); $i++) {
                $date = new DateTime('2022-01-01');
                $livre = new Book();
                $livre->setlibelle($faker->name());
                $livre->setprix(random_int(10, 300));
                $livre->setresume($faker->text());
                $livre->setImage("https://via.placeholder.com/300");

                $livre->setEditeur($faker->company());
                $livre->setDateEdition($date);
                $livre->setCategorie($cat);
                $manager->persist($livre);
            }
        }
        $manager->flush();
    }
}
