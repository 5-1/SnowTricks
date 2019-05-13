<?php
/**
 * Created by PhpStorm.
 * User: 51
 * Date: 11/03/2019
 * Time: 01:46
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\EmailType;
use AppBundle\Form\ResetPasswordType;
use AppBundle\Mailer\SendMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends Controller
{
    /**
     * @var SendMailer
     */
    private $sendMailer;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * ResetPasswordController constructor.
     * @param SendMailer $sendMailer
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(SendMailer $sendMailer, UrlGeneratorInterface $urlGenerator)
    {
        $this->sendMailer = $sendMailer;
        $this->urlGenerator = $urlGenerator;
    }


    /**
     * @Route(path="/reset", name="reset")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function resetForm(Request $request)
    {


        $form = $this->createForm(EmailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();

            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);


            if ($user)
            {
                $this->sendMailer->send('Réinisialiser votre mot de passe', ["no-reply@snowtrick.com" => "SnowTricks"], $user->getEmail(), 'emails/reset_password.html.twig', ['user' => $user,]);
                return new RedirectResponse($this->urlGenerator->generate('index'));



            }
            else{
                $form->get('email')->addError(new FormError("L'utilisateur avec cet email n'a pas été trouvé"));

            }


        }


        return $this->render('default/reset_form.html.twig', [
            'form' => $form->createView(),
        ]);


    }

    /**
     * @Route(path="/reset_password/{token}", name="reset_password")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function resetPassword(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $token = $request->attributes->get('token');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['token' => $token]);



        if(!$user)
        {
            return new RedirectResponse($this->urlGenerator->generate('index'));
        }

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $password = $form->get('password')->getData();
            $confirmPassword = $form->get('confirm_password')->getData();

            if($password != $confirmPassword)
            {
                $form->get('password')->addError(new FormError("Le mot de passe doit être correspondant !"));

            }

            $hash = $encoder->encodePassword($user, $password);
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
            return new RedirectResponse($this->urlGenerator->generate('security_login'));



        }

        return $this->render('default/reset_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}