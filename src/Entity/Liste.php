<?php

namespace App\Entity;

use App\Repository\ListeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeRepository::class)]
class Liste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nom = null;

    /**
     * @var Collection<int, ListeArticle>
     */
    #[ORM\OneToMany(targetEntity: ListeArticle::class, mappedBy: 'listes', orphanRemoval: true)]
    private Collection $listeArticles;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'listes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->listeArticles = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
        $this->dateCreation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $listeArticle->setListes($this);
        }

        return $this;
    }

    public function removeListeArticle(ListeArticle $listeArticle): static
    {
        if ($this->listeArticles->removeElement($listeArticle)) {
            // set the owning side to null (unless already changed)
            if ($listeArticle->getListes() === $this) {
                $listeArticle->setListes(null);
            }
        }

        return $this;
    }

    

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

}
