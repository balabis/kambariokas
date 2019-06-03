<?php

namespace App\Command;

use App\Entity\QuestionnaireScore;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoadUsersCommand extends Command
{

    private $faker;
    private $encoder;
    private $em;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct();
        $this->em = $em;
        $this->encoder = $encoder;
        $this->faker = Factory::create();
    }

    protected static $defaultName = 'app:loadUsers';

    protected function configure()
    {
        $this
            ->setDescription('Load fake Users')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cities = ['Vilnius', 'Kaunas', 'Klaipėda', 'Šiauliai', 'Panevėžys', 'Marijampolė'];

        foreach ($cities as $city) {
            for ($i = 0; $i < 15; $i++) {
                $user = $this->createUser($city, $i);
                $this->em->persist($user);
                $this->em->flush();
                $questionnaireScore = $this->createQuestionnaireScore($user->getId());
                $user->setQuestionnaireScore($questionnaireScore);
                $this->em->persist($questionnaireScore);
                $this->em->flush();
            }
        }
    }

    private function createUser($city, $i)
    {
        $budgets = ['iki 50eur/mėn', 'iki 100eur/mėn', 'iki 200eur/mėn', '> 200eur/mėn'];
        $genders = ['male','female'];
        $university = ['LSMU', 'KTU', 'VDU', 'VGTU', 'VU', null, null];
        $cityPart = ['Centras', 'Stoties', null];
        $gender = $genders[rand(0, 1)];
        $profilePicture = $gender == 'male' ?
            'uploads/profile_pictures/default/male.png' :
            'uploads/profile_pictures/default/female.png';

        $user = new User();
        $user->setCity($city);
        $user->setFullName($this->faker->name);
        $user->setEmail('fakeemail' . $i . '@' . $city . '.com');
        $user->setPassword($this->encoder->encodePassword($user, 'password'));
        $user->setGender($gender);
        $user->setProfilePicture($profilePicture);
        $user->setBudget($budgets[rand(0, 3)]);
        $date = rand(1960, 2000)."-05-11";
        $user->setDateOfBirth(new \DateTime($date));
        $user->setAboutme($this->faker->text(100));
        $user->setLastActivityAt($this->faker->dateTimeThisMonth());
        $user->setUniversity($university[rand(0, 6)]);
        $user->setCityPart($cityPart[rand(0, 2)]);

        return $user;
    }

    private function createQuestionnaireScore($userId)
    {
        $answer = new QuestionnaireScore();
        $answer->setUserId($userId);
        $answer->setCleanliness((rand(0, 100)/100));
        $answer->setSociability((rand(0, 100)/100));
        $answer->setSocialFlexibility((rand(0, 100)/100));
        $answer->setSocialOpenness((rand(0, 100)/100));

        return $answer;
    }
}

