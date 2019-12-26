<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use App\Form\PostType;
use Knp\Component\Pager\PaginatorInterface;

/**
* @Route("/posts")
*/
class PostsController extends AbstractController
{
    /**
     * @Route("/", name="admin.posts")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT a FROM App:Post a order by a.id DESC";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('admin/posts/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/add", name="admin.posts.add")
     */
    public function add(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $post = new Post;
        $post->setCreatedBy($this->getUser());

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($post);
            $em->flush();

            $this->addFlash(
                'global.success',
                'Post added'
            );

            return $this->redirectToRoute('admin.posts.edit', ['id' => $post->getId()]);
        }

        return $this->render('admin/posts/add_edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Add post',
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin.posts.edit")
     */
    public function edit(Post $post, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($post);
            $em->flush();

            //$this->addFlash(
            //    'global.success',
            //    'Post updated'
            //);

            return $this->redirectToRoute('admin.posts.edit', ['id' => $post->getId()]);
        }

        return $this->render('admin/posts/add_edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit post',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin.posts.delete")
     */
    public function delete(Post $post)
    {
        $em = $this->getDoctrine()->getManager();

        $em->delete($post);
        $em->flush();

        return $this->redirectToRoute('admin.posts');
    }
}
