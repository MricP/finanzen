<?php

namespace App\Repository;

use App\Entity\ListeArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListeArticle>
 */
class ListeArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListeArticle::class);
    }

       /**
        * @return ListeArticle[] Returns an array of ListeArticle objects
        */
       public function findAllMonthList($month): array
       {
            return $this->createQueryBuilder('la')
                ->join('la.liste', 'l')
                ->join('la.article', 'a')
                ->andWhere('la.date_creation = :month')
                ->setParameter('month', $month)
                ->addSelect('l.nom AS liste_nom, a.prix AS article_prix')
                ->getQuery()
                ->getResult();
       }

    //    public function findOneBySomeField($value): ?ListeArticle
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
