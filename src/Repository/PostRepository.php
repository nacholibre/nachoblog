<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function getUniqueMonthYearsPosts()
    {
        return $this->createQueryBuilder('p')
            ->addSelect("DATE_FORMAT(p.createdAt, '%m-%Y') as datef")
            ->groupBy('datef')
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAllPostsQuery($user=null, $dateFilter=null) {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
        ;

        if (!$user) {
            $qb->andWhere('p.draft = false');
        }

        if ($dateFilter) {
            $qb->andWhere('p.createdAt like :createdAt');
            $qb->setParameter('createdAt', $dateFilter->format('Y-m').'%');
        }

        return $qb->getQuery();
    }

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
