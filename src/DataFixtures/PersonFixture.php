<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PersonFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($i=0; $i<100 ; $i++){
            $person = new Person();
            $person->setFirstname($faker->firstName);
            $person->setName($faker->name);
            $person->setAge($faker->numberBetween(18, 65));

            $manager->persist($person);

        }
        $manager->flush();
    }
}
