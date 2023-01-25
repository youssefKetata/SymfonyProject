<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixutre extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $profile = new Profile();
        $profile->setRs('Facebook');
        $profile->setUrl('https://www.facebook.com/youssef.ketata.56/');

        $profile1 = new Profile();
        $profile1->setRs('Twitter');
        $profile1->setUrl('https://twitter.com/YoussefKetata1');

        $manager->persist($profile);
        $manager->persist($profile1);

        $manager->flush();
    }
}
