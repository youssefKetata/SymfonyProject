<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HobbyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $hobbies = [
            '3D printing',
            'Amateur radio',
            'Scrapbook',
            'Amateur radio',
            'Acting',
            'Baton twirling',
            'Board games',
            'Book restoration',
            'Cabaret',
            'Calligraphy',
            'Candle making',
            'Computer programming',
            'Coffee roasting',
            'Cooking',
            'Colouring',
            'Cosplaying',
            'Couponing',
            'Creative writing',
            'Crocheting',
            'Cryptography',
            'Dance',
            'Digital arts',
            'Drama',
            'Drawing'];
        for($i=0; $i<count($hobbies); $i++){
            $hobby = new Hobby();
            $hobby->setDesignation($hobbies[$i]);
            $manager->persist($hobby);
        }
        $manager->flush();
    }
}
