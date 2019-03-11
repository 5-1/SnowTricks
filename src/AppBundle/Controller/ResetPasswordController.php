<?php
/**
 * Created by PhpStorm.
 * User: 51
 * Date: 11/03/2019
 * Time: 01:46
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends Controller
{
    /**
     * @Route(path="/reset_password", name="reset")
     * @param Request $request
     */
    public function reset(Request $request)
    {

    }
}