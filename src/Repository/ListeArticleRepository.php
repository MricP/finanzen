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
        public function findMonthList(): array
        {
            $results = $this->createQueryBuilder('la')
            ->select('l.dateCreation AS date_creation, SUM(a.prix * la.quantite) AS total')
            ->join('la.listes', 'l') 
            ->join('la.articles', 'a')  
            ->groupBy('l.dateCreation')
            ->orderBy('l.dateCreation', 'ASC')
            ->where('la.est_achete = true')
            ->getQuery()
            ->getResult();
            
            $depensesParMois = [];
            

            foreach ($results as $row) {
                $date = $row['date_creation']; 
                if ($date instanceof \DateTimeInterface) {
                    $mois = (int) $date->format('n'); 
                    $depensesParMois[] = ['month' => $mois, 'total' => (float) $row['total']];
                }
            }


            return $depensesParMois;
        }


        public function findByCategory(): array
        {
            $currentMonth = date('m');
            $results = $this->createQueryBuilder('la')
            ->select('c.nom AS nom_categorie, l.dateCreation AS date_creation, SUM(a.prix * la.quantite) AS total')
            ->join('la.listes', 'l')
            ->join('la.articles', 'a')
            ->join('a.categorie', 'c')
            ->where('la.est_achete = true')
            ->andWhere('l.dateCreation LIKE :currentMonthPattern') 
            ->setParameter('currentMonthPattern', '%-' . $currentMonth . '-%') 
            ->groupBy('c.nom')
            ->getQuery()
            ->getResult();
            
            $depensesParCat = [];
            dump($results);
            foreach ($results as $row) {
                if ($row['date_creation'] instanceof \DateTimeInterface) {
                    if ($row['date_creation']->format('m') == $currentMonth) {
                        $depensesParCat[] = ['nom' => $row['nom_categorie'], 'categoryTot' => (float)$row['total']];
                    }
                }
            }

            return $depensesParCat;
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
