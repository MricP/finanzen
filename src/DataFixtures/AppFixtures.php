<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\User;
use App\Entity\Categorie;
use App\Entity\Article;
use App\Entity\Liste;
use App\Entity\ListeArticle;


class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->userPasswordHasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setPseudo("minh@ad.fr");
        $user->setEmail("minh@ad.fr");
        $user->setIsAdmin(1);
        $user->setRoles(["ROLE_ADMIN", "ROLE_USER"]);
        $user->setYearSpend(0);
        $user->setMonthSpend(0);
        $user->setMonthBudget(0);
        $user->setImage("default-user-icon.svg");
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "admin12"));
        $manager->persist($user);

        // Categorie 

        $category1 = new Categorie();
        $category1->setNom("Alimentation");
        $manager->persist($category1);

        $category2 = new Categorie();
        $category2->setNom("Hygiène");
        $manager->persist($category2);

        $category3 = new Categorie();
        $category3->setNom("Maison");
        $manager->persist($category3);

        $category4 = new Categorie();
        $category4->setNom("Loisirs");
        $manager->persist($category4);

        $category5 = new Categorie();
        $category5->setNom("Divers");
        $manager->persist($category5);

        $category6 = new Categorie();
        $category6->setNom("Transport");
        $manager->persist($category6);        

        $category7 = new Categorie();
        $category7->setNom("Vêtements");
        $manager->persist($category7);

        $category8 = new Categorie();
        $category8->setNom("Santé");
        $manager->persist($category8);

        $category9 = new Categorie();
        $category9->setNom("Autres");
        $manager->persist($category9);

        // Article
        $article1 = new Article();
        $article1->setCategorie($category1);
        $article1->setPrix(15.33);
        $article1->setNom("Pizza");
        $manager->persist($article1);

        $article2 = new Article();
        $article2->setCategorie($category1);
        $article2->setPrix(5.99);
        $article2->setNom("Chips");
        $manager->persist($article2);

        $article3 = new Article();
        $article3->setCategorie($category2);
        $article3->setPrix(9.99);
        $article3->setNom("Papier toilette");
        $manager->persist($article3);

        $article4 = new Article();
        $article4->setCategorie($category4);
        $article4->setPrix(19.99);
        $article4->setNom("Ballon de foot");
        $manager->persist($article4);


        // Liste 
        $liste1 = new Liste();
        $liste1->setNom("Mars");
        $liste1->setDateCreation(new \DateTime('2025-03-15'));
        $liste1->setUser($user);
        $manager->persist($liste1);

        $liste2 = new Liste();
        $liste2->setNom("Avril");
        $liste2->setDateCreation(new \DateTime());
        $liste2->setUser($user);
        $manager->persist($liste2);

        // ListeArticle

        $listeArticle1 = new ListeArticle();
        $listeArticle1->setArticles($article1);
        $listeArticle1->setListes($liste1);
        $listeArticle1->setQuantite(2);
        $listeArticle1->setEstAchete(true);
        $manager->persist($listeArticle1);

        $listeArticle2 = new ListeArticle();
        $listeArticle2->setArticles($article2);
        $listeArticle2->setListes($liste1);
        $listeArticle2->setQuantite(1);
        $listeArticle2->setEstAchete(true);
        $manager->persist($listeArticle2);

        $listeArticle3 = new ListeArticle();
        $listeArticle3->setArticles($article3);
        $listeArticle3->setListes($liste2);
        $listeArticle3->setQuantite(3);
        $listeArticle3->setEstAchete(true);
        $manager->persist($listeArticle3);

        $listeArticle4 = new ListeArticle();
        $listeArticle4->setArticles($article4);
        $listeArticle4->setListes($liste2);
        $listeArticle4->setQuantite(1);
        $listeArticle4->setEstAchete(false);
        $manager->persist($listeArticle4);


        $manager->flush();

    }
}
