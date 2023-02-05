<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie->setTitle('The Dark Knight');
        $movie->setReleaseYear(2008);
        $movie->setDescription('Description of The Dark Knight');
        $movie->setImagePath('https://www.hdwallpapers.net/previews/batman-the-dark-knight-387.jpg');

        $movie->addActor($this->getReference('actor_1'));
        $movie->addActor($this->getReference('actor_2'));
        $manager->persist($movie);

        $movie2 = new Movie();
        $movie2->setTitle('The Avengers');
        $movie2->setReleaseYear(2019);
        $movie2->setDescription('Description of The Avengers');
        $movie2->setImagePath('https://live.staticflickr.com/7278/6976641492_9368d1c2e4_b.jpg');

        $movie2->addActor($this->getReference('actor_3'));
        $movie2->addActor($this->getReference('actor_4'));
        $manager->persist($movie2);

        $manager->flush();
    }
}
