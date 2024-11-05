<?php

namespace App\DataFixtures;

use App\Entity\Organization;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrganizationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $organization = new Organization();
        $organization
            ->setName('Sensio Labs')
            ->setCreatedAt(new \DateTimeImmutable('2024-11-04'))
            ->setPresentation('Symfony SAS is the company behind Symfony, the PHP Open-Source framework.')
        ;

        for ($i = 0; $i < 10; $i++)
        {
            $organization->addEvent($this->getReference(EventFixtures::EVENT_REF.$i));
        }

        $manager->persist($organization);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventFixtures::class,
        ];
    }
}
