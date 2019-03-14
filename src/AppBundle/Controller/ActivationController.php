<?php
/**
 * Created by PhpStorm.
 * User: 51
 * Date: 11/03/2019
 * Time: 01:46
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Mailer\SendMailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class ActivationController extends Controller
{
    /**
     * @var SendMailer
     */
    private $sendMailer;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * ActivationController constructor.
     * @param SendMailer $sendMailer
     * @param Environment $twig
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(SendMailer $sendMailer, Environment $twig, UrlGeneratorInterface $urlGenerator)
    {
        $this->sendMailer = $sendMailer;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }


    /**
     * @Route(path="/activation/{token}", name="activation")
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function activation(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $token = $request->attributes->get('token');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['token' => $token]);

        if (!$user) {
            return new RedirectResponse($this->urlGenerator->generate('index'));
        } elseif ($user->getActivated() != 0) {
            return new RedirectResponse($this->urlGenerator->generate('index'));
        }

        $user->setActivated(1);
        $entityManager->flush();

        return $this->render('default/activation.html.twig');


    }


}