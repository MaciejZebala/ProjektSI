<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ContactFixtures.
 *
 */

class ContactFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */

    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'contacts', function ($i) {
            $contact = new Contact();
            $contact->setName($this->faker->firstName);
            $contact->setSurname($this->faker->lastName);
            $contact->setPhoneNumber($this->faker->phoneNumber);
            $contact->setEmail($this->faker->email);

            return $contact;
        });

        $manager->flush();
    }

//    /**
//     * This method must return an array of fixtures classes
//     * on which the implementing class depends on.
//     *
//     * @return array Array of dependencies
//     */
//    public function getDependencies()
//    {
//        return [EventFixtures::class];
//    }
}