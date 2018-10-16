<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trick;
use AppBundle\Form\TrickType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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


    /**
     * @Route("/ajouter-une-figure", name="trick_add")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addTrick(Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(TrickType::class);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $trick = $form->getData();
            $manager->persist($trick);
            $manager->flush();

            return $this->redirectToRoute('tricks_show', ['id' => $trick->getId()]);
        }

        return $this->render('default/log.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/editer-une-figure/{id}", name="trick_edit")
     * @param Trick $trick
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editTrick(Trick $trick, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $trick = $form->getData();
            $manager->flush();

            return $this->redirectToRoute('tricks_show', ['id' => $trick->getId()]);
        }

        return $this->render('default/log.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/trick/{id}", name="tricks_show")
     * @param Trick $trick
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function trickShow(Trick $trick)
    {
        return $this->render('default/tricks.html.twig', ['trick' => $trick]);
    }
}
