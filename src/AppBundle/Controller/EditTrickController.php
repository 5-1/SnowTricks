<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trick;
use AppBundle\Form\TrickEditType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class EditTrickController extends AbstractController
{


    /**
     * @Route("/editer-une-figure/{id}", name="trick_edit")
     * @param Trick $trick
     * @IsGranted("ROLE_USER")
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

            $this->addFlash("success", "Votre figure a bien été modifiée");

            return $this->redirectToRoute('tricks_show', ['id' => $trick->getId()]);
        }


        return $this->render('views/default/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}