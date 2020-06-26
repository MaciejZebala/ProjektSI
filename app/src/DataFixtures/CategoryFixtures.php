<?php

/**
 * Category fixture.
 */
namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class CategoryFixtures.
 */
class CategoryFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
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
        $this->createMany(10, 'categories', function ($i) {
            $category = new Category();
            $newWord = $this->faker->unique()->word;
            $this->values[] = $newWord;
            $category->setTitle($newWord);
            $category->setUser($this->getRandomReference('users'));

            return $category;
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
        return [UserFixtures::class];
    }
}
