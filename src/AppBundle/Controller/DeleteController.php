<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * @var FormFactoryInterface
     *
     */
    private $formFactory;

    /**
     * DeleteController constructor.
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }


    /**
     * @Route("/supprimer-une-figure/{id}", name="trick_delete")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteTrick(Request $request, EntityManagerInterface $manager)
    {
        $trick = $this->getDoctrine()->getRepository(Trick::class)->find($request->attributes->get('id'));
        $submittedToken = $request->request->get('token');


        if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
            $manager->remove($trick);
            $manager->flush();
        }

        return new RedirectResponse($this->generateUrl('index'));

    }
}