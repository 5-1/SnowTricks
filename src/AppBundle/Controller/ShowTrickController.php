<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Trick;
use AppBundle\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ShowTrickController extends AbstractController
{


    /**
     * @Route("/trick/{id}", name="tricks_show")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function trickShow(Request $request, EntityManagerInterface $manager): Response
    {
        $trick = $this->getDoctrine()->getRepository(Trick::class)->find($request->attributes->get('id'));
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() && $this->getUser()) {
            $comment->setCreatedAt(new \DateTime())
                ->setTrick($trick);
            $comment->setUser($this->getUser());
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('tricks_show', ['id' => $trick->getId()]);
        }

        return $this->render('views/default/tricks.html.twig', ['trick' => $trick, 'commentForm' => $form->createView()]);
    }

}