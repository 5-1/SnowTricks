<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Trick;
use AppBundle\Form\TrickType;
use AppBundle\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddTrickController extends Controller
{


    /**
     * @Route("/ajouter-une-figure", name="trick_add")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addTrick(Request $request, EntityManagerInterface $manager, FileUploader $fileUploader)
    {

        $form = $this->createForm(TrickType::class);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Trick $trick */
            $trick = $form->getData();


            /**foreach ($trick->getImages() as $image) {
             * $fileName = $fileUploader->upload($image->getFile());
             * $image->setFile($fileName);
             * }**/

            $manager->persist($trick);
            $manager->flush();

            return $this->redirectToRoute('tricks_show', ['id' => $trick->getId()]);
        }

        return $this->render('default/new.html.twig', ['form' => $form->createView()]);
    }
}