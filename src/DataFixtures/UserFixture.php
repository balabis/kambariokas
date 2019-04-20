<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail('dummyemail' . $i . '@mail.com')
              ->setPassword($this->passwordEncoder->encodePassword($user,
                'the_new_password'));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
