<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for($i = 0;$i <= 50; $i++){
            $episode = new Episode();
            $episode->setSeason($this->getReference('season_' . rand(0, 50)));
            $episode->setNumber($faker->randomDigitNotNull);
            $episode->setTitle($faker->title);
            $episode->setSynopsis($faker->text);
            $manager->persist($episode);
            $this->addReference('episode_' . $i, $episode);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}
