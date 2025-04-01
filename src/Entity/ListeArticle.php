<?php

namespace App\Entity;

use App\Repository\ListeArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeArticleRepository::class)]
class ListeArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $est_achete = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'listeArticles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Article $articles = null;

    #[ORM\ManyToOne(inversedBy: 'listeArticles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Liste $listes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEstAchete(): ?bool
    {
        return $this->est_achete;
    }

    public function setEstAchete(bool $est_achete): static
    {
        $this->est_achete = $est_achete;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getArticles(): ?Article
    {
        return $this->articles;
    }

    public function setArticles(?Article $articles): static
    {
        $this->articles = $articles;

        return $this;
    }

    public function getListes(): ?Liste
    {
        return $this->listes;
    }

    public function setListes(?Liste $listes): static
    {
        $this->listes = $listes;

        return $this;
    }

    public function getTotal(): float
    {
        return $this->quantite * $this->articles->getPrix();
    }
}
