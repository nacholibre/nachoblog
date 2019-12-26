<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;

class AppExtension extends AbstractExtension {
    function __construct(EntityManagerInterface $em, RouterInterface $router) {
        $this->em = $em;
        $this->router = $router;
    }

    public function getFilters() {
        return [
            //new TwigFilter('str_pad', [$this, 'strPad']),
        ];
    }

    public function getFunctions() {
        return [
            new TwigFunction('get_sidebar_archive', [$this, 'getSidebarArchive']),
        ];
    }

    public function getSidebarArchive() {
        $repo = $this->em->getRepository('App:Post');

        $data = $repo->getUniqueMonthYearsPosts();

        return $data;
    }
}
