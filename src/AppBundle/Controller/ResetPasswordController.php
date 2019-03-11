<?php
/**
 * Created by PhpStorm.
 * User: 51
 * Date: 11/03/2019
 * Time: 01:46
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\ResetPasswordType;
use AppBundle\Mailer\SendMailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends Controller
{
    /**
     * @var SendMailer
     */
    private $sendMailer;

    /**
     * ResetPasswordController constructor.
     * @param SendMailer $sendMailer
     */
    public function __construct(SendMailer $sendMailer)
    {
        $this->sendMailer = $sendMailer;
    }


    /**
     * @Route(path="/reset_password", name="reset")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function resetForm(Request $request)
    {


        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();

            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$user) {
                $form->get('email')->addError(new FormError("test"));

            }

            $this->sendMailer->send('Réinisialiser votre mot de passe', ["no-reply@snowtrick.com" => "SnowTricks"], $user->getEmail(), 'emails/reset_password.html.twig', ['user' => $user,]);

        }


        return $this->render('default/reset_form.html.twig', [
            'form' => $form->createView(),
        ]);


    }

    /**
     * @Route(path="/reset_password/{token}", name="reset_password")
     * @param Request $request
     */
    public function resetPassword(Request $request)
    {


    }
}