<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/home", name="index")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }


    /**
     * @Route("/form", name="form")
     */
    public function create (Request $request,EntityManagerInterface $manager)
    {

        $form = $this->createFormBuilder()
            ->add('title')
            ->add('content')
            ->add('image')
            ->getForm();

        return $this->render('default/log.html.twig', ['form' => $form->createView()]);


    }



    /**
     * @Route("/tricks", name="tricks")
     */
    public  function tricks()
    {
        return $this->render('default/tricks.html.twig');
    }
}
