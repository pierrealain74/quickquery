<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Faker\Factory;
use Faker\Generator;

use App\Entity\User;
use App\Entity\Question;


class AppFixtures extends Fixture
{
    private Generator $faker;


    public function __construct()
    {
        $this->faker = Factory::create('us_US');
    }

    public function load(ObjectManager $manager): void
    {
        $users = [];
        for ($i = 0; $i < 10; $i++)
        {
            $user = new User();
            $user->setEmail($this->faker->email())
                ->setPseudo($this->faker->firstName())
                ->setPassword('password')
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');
                $users[] = $user;
                $manager->persist($user);
        }

        $manager->flush();
    }
}
