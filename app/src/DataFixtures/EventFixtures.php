<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class EventFixtures.
 */
class EventFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'events', function ($i) {
            $event = new Event();
            $event->setTitle($this->faker->sentence);
            $event->setDate($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $event->setCategory($this->getRandomReference('categories'));
            $event->setUser($this->getRandomReference('users'));

            $tags = $this->getRandomReferences(
                'tags',
                $this->faker->numberBetween(0, 5)
            );

            foreach ($tags as $tag) {
                $event->addTag($tag);
            }

            $contacts = $this->getRandomReferences(
                'contacts',
                $this->faker->numberBetween(0, 5)
            );

            foreach ($contacts as $contact) {
                $event->addContact($contact);
            }

            return $event;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies()
    {
        return [CategoryFixtures::class, TagFixtures::class, ContactFixtures::class, UserFixtures::class];
    }
}
