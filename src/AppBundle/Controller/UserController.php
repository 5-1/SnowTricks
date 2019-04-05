<?php

namespace AppBundle\Controller;


use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/compte", name="compteuser")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @IsGranted("ROLE_USER")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editUser(Request $request, EntityManagerInterface $manager)
    {

        return $this->render('default/user.html.twig');


    }
}