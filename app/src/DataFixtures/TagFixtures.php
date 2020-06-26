<?php

/**
 * Tag fixture.
 */

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TagFixtures.
 */
class TagFixtures extends AbstractBaseFixtures
{
    /**
     * Tags that were already added.
     *
     * @var array
     */
    private $values = [];

    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {

        $this->createMany(10, 'tags', function ($i) {
            $tag = new Tag();
            $newWord = $this->faker->unique()->regexify('[a-z]{3,7}');
            $this->values[] = $newWord;
            $tag->setName($newWord);

            return $tag;
        });

        $manager->flush();
    }
}
