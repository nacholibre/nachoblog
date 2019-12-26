<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/{slug}.html", name="post.view")
     */
    public function view($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('App:Post');

        $post = $repo->findOneBy(['slug' => $slug]);

        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        return $this->render('post/index.html.twig', [
            'title' => $post->getTitle(),
            'post' => $post,
        ]);
    }
}
