<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trick;
use AppBundle\Form\TrickEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class EditTrickController extends Controller
{


    /**
     * @Route("/editer-une-figure/{id}", name="trick_edit")
     * @param Trick $trick
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editTrick(Trick $trick, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(TrickEditType::class, $trick);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $trick = $form->getData();
            $manager->flush();

            $this->addFlash("success", "Votre figure à bien était modifiée");

            return $this->redirectToRoute('tricks_show', ['id' => $trick->getId()]);
        }


        return $this->render('default/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}