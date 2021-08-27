<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Figure;
use App\Entity\Media;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $encoder;
      
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
      $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // using faker
        $faker = Factory::create('fr_FR');

        // create user
        $user = new User();
        $user->setEmail('another@test.com')
             ->setUsername($faker->name())
             ->setFirstname($faker->firstName())
             ->setLastname($faker->lastName())
             ->setPhoto('/assets/img/girl.png');
        $password = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($password);

        $manager->persist($user);

        // create figures and groups
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setName($faker->name())
                     ->setDescription($faker->words(10, true))
                     ->setSlug($faker->slug());

            $manager->persist($category);  

            for ($j = 0; $j < 2; $j++) {
                $media = new Media();
                $media->setName($faker->words(3, true))
                      ->setType('image');
                      
                $manager->persist($media);

                $figure = new Figure();
                $figure->setName($faker->words(3, true))
                       ->setDescription($faker->text())
                       ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
                       ->setSlug($faker->slug())
                       ->setUser($user)
                       ->addCategory($category)
                       ->addMedium($media);
                
                $manager->persist($figure);
            }
        }

        $manager->flush();
    }
}
