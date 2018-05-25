<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BookDataFixture extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entity1 = new Category("Kategorie1");
        $manager->persist($entity1);

        $entity = new Book("Kniha1", new \DateTime(), new \DateTime(), 1, 0, [
            $entity1
        ]);
        $manager->persist($entity);
        $manager->flush();
    }
}
