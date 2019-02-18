<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class AjaxController extends Controller
{
    /**
     * @Route("/ajax", name="load_more", methods={"POST"})
     */
    public function ajax(Request $request)
    {
        $offset = $request->request->get('offset');
        $limit = $request->request->get('limit');

        $repo = $this->getDoctrine()->getRepository(Trick::class);
        $tricks = $repo->findBy(array(), array('id' => 'DESC'), $limit, $offset);


        $tricksArray = [];

        foreach ($tricks as $trick) {

            /** @var Image $mainImage */
            $mainImage = $trick->getImages()->first();
            if ($mainImage == false) {
                $mainImage = "assets/images/header-bg.jpg";
            } else {
                $mainImage = $mainImage->getWebPath();
            }
            $tricksArray[] = ['id' => $trick->getId(),
                'title' => $trick->getTitle(),
                'content' => $trick->getContent(),
                'category' => $trick->getCategory(),
                'slug' => $trick->getSlug(),
                'image' => $mainImage,
            ];


        }


        return new JsonResponse($tricksArray);


    }

}
