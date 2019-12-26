<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ArchiveController extends AbstractController
{
    /**
     * @Route("/archive/{year}/{month}", name="archive.view")
     */
    public function view($year, $month, PaginatorInterface $paginator, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('App:Post');

        $date = \DateTime::createFromFormat('Y-m-d', implode('-', [$year, $month, '1']));

        $title = 'Archive ' . $date->format('F Y');

        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT a FROM App:Post a where a.createdAt like :createdAt order by a.id DESC";
        $query = $em->createQuery($dql);
        $query->setParameter('createdAt', $date->format('Y-m').'%');

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('archive/view.html.twig', [
            'title' => $title,
            'pagination' => $pagination,
        ]);
    }
}
