<?php

namespace App\DataFixtures;

use App\Entity\Author;
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
        $author = new Author("Professor Farnsworth", "Author description", new \DateTime(), new \DateTime());
        $manager->persist($author);

        $category = new Category("Kategorie1", "Description");
        $manager->persist($category);
        $category2 = new Category("Kategorie2", "Description");
        $manager->persist($category2);

        $book = new Book("Kniha1", $author, [$category, $category2], new \DateTime(), new \DateTime());
        $manager->persist($book);

        $manager->flush();
    }
}
