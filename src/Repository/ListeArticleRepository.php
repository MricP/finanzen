<?php

namespace App\Repository;

use App\Entity\ListeArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface; 
use App\Entity\User;
use Symfony\Component\Security\Core\Security;

/**
 * @extends ServiceEntityRepository<ListeArticle>
 */
class ListeArticleRepository extends ServiceEntityRepository
{
    private $tokenStorage;

    public function __construct(ManagerRegistry $registry, TokenStorageInterface $tokenStorage)
    {
        parent::__construct($registry, ListeArticle::class);
        $this->tokenStorage = $tokenStorage;
    }

       /**
        * @return ListeArticle[] Returns an array of ListeArticle objects
        */
        public function findMonthList(): array
        {
            $token = $this->tokenStorage->getToken();

            if (!$token) {
                return []; 
            }
            $user = $token->getUser();


            $results = $this->createQueryBuilder('la')
            ->select('l.dateCreation AS date_creation, SUM(a.prix * la.quantite) AS total')
            ->join('la.listes', 'l') 
            ->join('la.articles', 'a')
            ->join('l.user', 'u')
            ->where('la.est_achete = true')
            ->andWhere('u.id = :userId')
            ->setParameter('userId', $user->getId())
            ->groupBy('date_creation')
            ->getQuery()
            ->getResult();
            
            $depensesParMois = [];
            
            dump($results);
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
            $token = $this->tokenStorage->getToken();

            if (!$token) {
                return []; 
            }


            $user = $token->getUser();
            $currentMonth = date('m');
            $results = $this->createQueryBuilder('la')
            ->select('c.nom AS nom_categorie, l.dateCreation AS date_creation, SUM(a.prix * la.quantite) AS total')
            ->join('la.listes', 'l')
            ->join('la.articles', 'a')
            ->join('a.categorie', 'c')
            ->join('l.user', 'u')
            ->where('la.est_achete = true')
            ->andWhere('l.dateCreation LIKE :currentMonth') 
            ->andWhere('u.id = :userId')
            ->setParameter('currentMonth', '%-' . $currentMonth . '-%') 
            ->setParameter('userId', $user->getId())
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
