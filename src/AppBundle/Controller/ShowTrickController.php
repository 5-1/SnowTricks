<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Trick;
use AppBundle\Form\CommentType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ShowTrickController extends Controller
{


    /**
     * @Route("/trick/{id}", name="tricks_show")
     * @param Trick $trick
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function trickShow(Trick $trick, Request $request, ObjectManager $manager)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime())
                ->setTrick($trick);
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('tricks_show', ['id' => $trick->getId()]);
        }


        return $this->render('default/tricks.html.twig', ['trick' => $trick, 'commentForm' => $form->createView()]);
    }

}
