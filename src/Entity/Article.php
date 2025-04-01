<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?Categorie $categorie = null;

    /**
     * @var Collection<int, Magasin>
     */
    #[ORM\ManyToMany(targetEntity: Magasin::class, mappedBy: 'articles')]
    private Collection $magasins;

    /**
     * @var Collection<int, ListeArticle>
     */
    #[ORM\OneToMany(targetEntity: ListeArticle::class, mappedBy: 'articles', orphanRemoval: true)]
    private Collection $listeArticles;

    public function __construct()
    {
        $this->magasins = new ArrayCollection();
        $this->listeArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }



    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Magasin>
     */
    public function getMagasins(): Collection
    {
        return $this->magasins;
    }

    public function addMagasin(Magasin $magasin): static
    {
        if (!$this->magasins->contains($magasin)) {
            $this->magasins->add($magasin);
            $magasin->addArticle($this);
        }

        return $this;
    }

    public function removeMagasin(Magasin $magasin): static
    {
        if ($this->magasins->removeElement($magasin)) {
            $magasin->removeArticle($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ListeArticle>
     */
    public function getListeArticles(): Collection
    {
        return $this->listeArticles;
    }

    public function addListeArticle(ListeArticle $listeArticle): static
    {
        if (!$this->listeArticles->contains($listeArticle)) {
            $this->listeArticles->add($listeArticle);
            $listeArticle->setArticles($this);
        }

        return $this;
    }

    public function removeListeArticle(ListeArticle $listeArticle): static
    {
        if ($this->listeArticles->removeElement($listeArticle)) {
            // set the owning side to null (unless already changed)
            if ($listeArticle->getArticles() === $this) {
                $listeArticle->setArticles(null);
            }
        }

        return $this;
    }

    public function __toString(): string{
        $categorieNom = $this->getCategorie() ? $this->getCategorie()->getNom() : 'Aucune';

        return sprintf(
            "%s (%s €) - Catégorie: %s",
            $this->nom,
            $this->prix,
            $categorieNom
        );
        }
}
