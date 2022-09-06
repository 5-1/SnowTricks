<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository(Trick::class);
        $trick = $repo->findAll();

        return $this->render('views/default/index.html.twig', ['controller_name' => 'DefaultController', 'tricks' => $trick]);
    }

}