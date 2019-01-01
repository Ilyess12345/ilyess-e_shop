<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProduitCommande", mappedBy="categorie")
     */
    private $produitCommandes;

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getNom() : ? string
    {
        return $this->nom;
    }

    public function setNom(string $nom) : self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom() : ? string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom) : self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail() : ? string
    {
        return $this->email;
    }

    public function setEmail(string $email) : self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse() : ? string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse) : self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDate() : ? \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date) : self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|ProduitCommande[]
     */
    public function getProduitCommandes() : Collection
    {
        return $this->produitCommandes;
    }

    public function addProduitCommande(ProduitCommande $produitCommande) : self
    {
        if (!$this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes[] = $produitCommande;
            $produitCommande->setCategorie($this);
        }

        return $this;
    }

    public function removeProduitCommande(ProduitCommande $produitCommande) : self
    {
        if ($this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes->removeElement($produitCommande);
            // set the owning side to null (unless already changed)
            if ($produitCommande->getCategorie() === $this) {
                $produitCommande->setCategorie(null);
            }
        }

        return $this;
    }
}
