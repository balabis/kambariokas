<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail('dummyemail' . $i . '@mail.com');
            $manager->persist($user);
        }

        $manager->flush();
    }
}
