<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Persistence\ObjectManager;

/**
 * Class EventFixtures.
 */
class EventFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */

    public function loadData(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $event = new Event();
            $event->setTitle($this->faker->sentence);
            $event->setDate($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $this->manager->persist($event);
        }
        $manager->flush();
    }
}
