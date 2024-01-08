<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
class Commandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $N°commande = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateCommande = null;

    #[ORM\Column(length: 255)]
    private ?string $PaiementValide = null;

    #[ORM\Column]
    private ?int $Prix_total = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom_produit = null;

    #[ORM\Column]
    private ?int $Quantite = null;



    #[ORM\Column(length: 255)]
    private ?string $adresse_livraison = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getN°commande(): ?int
    {
        return $this->N°commande;
    }

    public function setN°commande(int $N°commande): static
    {
        $this->N°commande = $N°commande;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->DateCommande;
    }

    public function setDateCommande(\DateTimeInterface $DateCommande): static
    {
        $this->DateCommande = $DateCommande;

        return $this;
    }

    public function getPaiementValide(): ?string
    {
        return $this->PaiementValide;
    }

    public function setPaiementValide(string $PaiementValide): static
    {
        $this->PaiementValide = $PaiementValide;

        return $this;
    }

    public function getPrixTotal(): ?int
    {
        return $this->Prix_total;
    }

    public function setPrixTotal(int $Prix_total): static
    {
        $this->Prix_total = $Prix_total;

        return $this;
    }

    public function getNomProduit(): ?string
    {
        return $this->Nom_produit;
    }

    public function setNomProduit(string $Nom_produit): static
    {
        $this->Nom_produit = $Nom_produit;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->Quantite;
    }

    public function setQuantite(int $Quantite): static
    {
        $this->Quantite = $Quantite;

        return $this;
    }


    public function getAdresseLivraison(): ?string
    {
        return $this->adresse_livraison;
    }

    public function setAdresseLivraison(string $adresse_livraison): static
    {
        $this->adresse_livraison = $adresse_livraison;

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
