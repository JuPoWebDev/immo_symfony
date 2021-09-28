<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Picture;
use App\Entity\Property;
use App\DataFixtures\AppFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // $product = new Product();
        // $manager->persist($product);

        for ($v=0; $v < 5; $v++) { 
            $user = new User;
            $user->setEmail($faker->safeEmail);
            $user->setFirstname($faker->firstName($gender = null));
            $user->setLastname($faker->lastName);
            $user->setPassword("0123"
            );
            $user->setPhone($faker->phoneNumber);

            $manager->persist($user);






        for ($i=0; $i < 10; $i++) { 
            $property = new Property;
             $property->setTitle("Titre" .$i);
            $property->setSurface($faker->randomNumber($nbDigits = 4, $strict = false));
            $property->setContent("Lorem ipsum dolor, sit amet consectetur adipisicing elit.Lorem ipsum dolor, sit amet consectetur adipisicing elit.Lorem ipsum dolor, sit amet consectetur adipisicing elit.Lorem ipsum dolor, sit amet consectetur adipisicing elit.Lorem ipsum dolor, sit amet consectetur adipisicing elit.");
            $property->setFloor($faker->numberBetween($min = 1, $max = 150));
            $property->setRooms($faker->numberBetween($min = 1, $max = 30));
            $property->setAddress($faker->streetAddress);
            $property->setZipcode($faker->postcode);
            $property->setCity($faker->city);
            $property->setType($faker->randomElement($array = array ('Maison','Appartement','Batiment commercial / industriel')));
            $property->setTransactionType($faker->randomElement($array = ['Vente','Location']));

                $property->setPrice($faker->numberBetween($min = 100, $max = 100000) . 00);

                $property->setPrice($faker->numberBetween($min = 100, $max = 2500));

            $property->setGroundSize($faker->numberBetween($min = $property->getSurface(), $max = ($property->getSurface() + 2000)));
            $property->setDateOfConstruction($faker->numberBetween($min = 1800, $max = 2021));
            $property->setSell($faker->boolean($chanceOfGettingTrue = 15));
            $property->setSlug($faker->word);
            $property->setEmployee($user);


  
            

            $manager->persist($property);

            for ($y=0; $y < 3; $y++) { 

                $picture = new Picture; 
                $picture->setName($faker->imageUrl(1080, 720, 'cats'));
                $picture->setProperty($property);

                $manager->persist($picture);

            }

        }
     }


        $manager->flush();
    }
}
