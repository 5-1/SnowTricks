<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends Controller
{
    /**
     * @var AuthenticationUtils
     */
    private $authenError;

    /**
     * SecurityController constructor.
     * @param AuthenticationUtils $authenError
     */
    public function __construct(AuthenticationUtils $authenError)
    {
        $this->authenError = $authenError;
    }


    /**
     * @Route("/inscription", name="security_registration")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }
        return $this->render('default/registration.html.twig', ['form' => $form->createView()

        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login()
    {
        $error = $this->authenError->getLastAuthenticationError();

        return $this->render('default/login.html.twig', [
            'error' => $error,
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){}
}
