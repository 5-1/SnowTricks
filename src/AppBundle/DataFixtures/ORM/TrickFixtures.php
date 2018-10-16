<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $trick = new Trick();
            $trick->setTitle("Titre du tricks n$i")
                ->setContent("<p>contenu tricks n$i</p>")
                ->setImage("http://placehold.it/350*150")
                ->setCreatedAt(new \DateTime());
            $manager->persist($trick);
        }
        $manager->flush();
    }
}