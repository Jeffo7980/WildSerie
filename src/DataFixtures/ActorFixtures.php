<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\File;

class ActorFixtures extends Fixture
{
    const ACTOR = [
        'Andrew-lincoln',
        'norman-reedus',
        'lauren-cohan',
        'danai-gurira'
    ];
    public function load(ObjectManager $manager)
    {

        foreach (self::ACTOR as $key => $name){
            $actor = new Actor();
            $actor->setName($name);
            $manager->persist($actor);
            $this->addReference('actor_' . $key, $actor);
        }
        $faker = Factory::create('fr_FR');

        for($i = 4; $i <= 50; $i++){
            $actor = new Actor();
            $actor->setName($faker->name);
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);

        }
        $manager->flush();
    }

}
