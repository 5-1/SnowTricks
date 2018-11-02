<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TrickFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Doctrine\Common\DataFixtures\BadMethodCallException
     */
    public function load(ObjectManager $manager)
    {
        $categories = ['Grabs', 'Rotations'];

        foreach ($categories as $cat){
            $category = new Category();
            $category->setName($cat);
            $manager->persist($category);
            $this->addReference('CAT_'.$cat, $category);
        }


        for ($i = 1; $i <= 10; $i++) {
            $trick = new Trick();
            $trick->setTitle("Titre du tricks n$i")
                ->setContent("<p>contenu tricks n$i</p>")
                ->setImage("http://placehold.it/350*150")
                ->setCreatedAt(new \DateTime());
            $trick->setCategory($this->getReference('CAT_Grabs'));
            $manager->persist($trick);
        }
        $manager->flush();
    }
}