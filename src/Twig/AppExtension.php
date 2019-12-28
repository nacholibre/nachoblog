<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use App\Entity\Post;

class AppExtension extends AbstractExtension {
    function __construct(EntityManagerInterface $em, RouterInterface $router) {
        $this->em = $em;
        $this->router = $router;
    }

    public function getFilters() {
        return [
            new TwigFilter('strip_readmore', [$this, 'stripReadmore']),
        ];
    }

    public function stripReadmore($html) {
        $html = str_replace('<p>'.Post::READMORE_SPLIT_TAG.'</p>', '', $html);
        $html = str_replace(Post::READMORE_SPLIT_TAG, '', $html);
        return $html;
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
