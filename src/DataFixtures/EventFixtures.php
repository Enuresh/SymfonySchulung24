<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public const string EVENT_REF = 'events';
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++)
        {
            $event = new Event();
            $event
                ->setName('Symfony Schulung Event')
                ->setDescription('This is the event symfony Schulung Event.')
                ->setAccessible(true)
                ->setStartAt(new \DateTimeImmutable('2024-11-04'))
                ->setEndAt(new \DateTimeImmutable('2024-11-07'))
            ;

            $manager->persist($event);
            $manager->flush();
            $this->addReference(self::EVENT_REF.$i, $event);
        }
    }
}
