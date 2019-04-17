<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class CommentsAjaxController extends Controller
{
    /**
     * @Route("/ajax_comment/{id}", name="comments_more", methods={"POST"})
     * @param Trick $trick
     * @param Request $request
     * @return JsonResponse
     */
    public function ajax(Trick $trick, Request $request)
    {
        $offset = $request->request->get('offset',0);
        $limit = $request->request->get('limit',4);

        $repo = $this->getDoctrine()->getRepository(Comment::class);
        $comments = $repo->findBy(['trick'=> $trick], array('id' => 'DESC'), $limit, $offset);


        $commentsArray = [];

        foreach ($comments as $comment) {

            $commentsArray[] = ['id' => $comment->getId(),
                'user' =>$comment->getUser()->getUsername(),
                'date' => $comment->getCreatedAt()->format('d-m-Y H:i:s'),
                'content' => $comment->getContent(),
            ];
        }


        return new JsonResponse($commentsArray);

    }

}
