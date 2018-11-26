<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trick;

use AppBundle\Form\CommentType;
use AppBundle\Form\TrickType;
use AppBundle\Service\FileUploader;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
>>>>>>> change name of view "log" for " new" for better comprehension
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $repo = $this->getDoctrine()->getRepository(Trick::class);
        $trick = $repo->findAll();

        return $this->render('default/index.html.twig', ['controller_name' => 'DefaultController', 'tricks' => $trick]);
    }

}