<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $count = 50;
        $phone = function (int $length = 11) {
            $sequence = '';
            for ($i = 0; $i < $length; $i++) {
                $sequence .= random_int(0, 9);
            }
            return $sequence;
        };

        for ($index = 1; $index <= $count; $index++) {
            $client = new Client();
            $client->setName("Тест$index Тестович$index Тестовой$index");
            $client->setPhone($phone());
            $client->setEmail("test$index@mail.com");
            $manager->persist($client);

            foreach (range(1, random_int(1, 5)) as $addressIndex) {
                $address = new Address();
                $address->setCity("Тестовый$addressIndex");
                $address->setAddress("ул. Тестовая$addressIndex, д. $addressIndex");
                $address->setClient($client);
                $manager->persist($address);
            }
        }

        $manager->flush();
    }
}
