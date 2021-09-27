<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Picture;
use App\Entity\Property;
use App\DataFixtures\AppFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        // $product = new Product();
        // $manager->persist($product);

        for ($v=0; $v < 5; $v++) { 
            $user = new User;
            $user->setEmail($faker->safeEmail);
            $user->setFirstname($faker->firstName($gender = null));
            $user->setLastname($faker->lastName);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('0123')->getData()
                )
            );
            $user->setPhone($faker->phoneNumber);

            $manager->persist($user);






        for ($i=0; $i < 10; $i++) { 
            $property = new Property;
            $property->setTitle($faker->text($maxNbChars = 30));
            $property->setSurface(faker->randomNumber($nbDigits = 4, $strict = false));
            $property->setContent($faker->text($maxNbChars = 255));
            $property->setFloor($faker->numberBetween($min = 1, $max = 150));
            $property->setRooms($faker->numberBetween($min = 1, $max = 30));
            $property->setAddess($faker->streetAddress);
            $property->setZipcode($faker->postcode);
            $property->setCity($faker->city);
            $property->setType($faker->randomElement($array = array ('Maison','Appartement','Batiment commercial / industriel')));
            $property->setTransactionType($faker->randomElement($array = array ('Vente','Location')));
            if($property->getTransactionType == 'Vente') {
                $property->setPrice($faker->numberBetween($min = 100, $max = 100000) . 00);
            } else {
                $property->setPrice($faker->numberBetween($min = 100, $max = 2500));
            }
            $property->setGroundSize($faker->numberBetween($min = $property->getSurface(), $max = ($property->getSurface() + 2000)));
            $property->setDateOfConstruction($faker->numberBetween($min = 1800, $max = 2021));
            $property->setSell($faker->boolean($chanceOfGettingTrue = 15));
            $property->setSlug($faker->word);
            $property->setEmployee($v);

            $manager->persist($property);

            for ($y=0; $y < 3; $y++) { 

                $picture = new Picture; 
                $picture->setName($faker->imageUrl($width, $height, 'house'));
                $picture->setProperty($i);

                $manager->persist($picture);

            }


        }
     }


        $manager->flush();
    }
}
