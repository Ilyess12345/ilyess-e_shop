<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
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
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descCourt;

    /**
     * @ORM\Column(type="text")
     */
    private $descLong;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageP;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageSec1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageSec2;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie", inversedBy="produits")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Avis", mappedBy="produit")
     */
    private $avis;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProduitCommande", mappedBy="produit")
     */
    private $produitCommandes;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->produitCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescCourt(): ?string
    {
        return $this->descCourt;
    }

    public function setDescCourt(string $descCourt): self
    {
        $this->descCourt = $descCourt;

        return $this;
    }

    public function getDescLong(): ?string
    {
        return $this->descLong;
    }

    public function setDescLong(string $descLong): self
    {
        $this->descLong = $descLong;

        return $this;
    }

    public function getImageP(): ?string
    {
        return $this->imageP;
    }

    public function setImageP(string $imageP): self
    {
        $this->imageP = $imageP;

        return $this;
    }

    public function getImageSec1(): ?string
    {
        return $this->imageSec1;
    }

    public function setImageSec1(?string $imageSec1): self
    {
        $this->imageSec1 = $imageSec1;

        return $this;
    }

    public function getImageSec2(): ?string
    {
        return $this->imageSec2;
    }

    public function setImageSec2(?string $imageSec2): self
    {
        $this->imageSec2 = $imageSec2;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @return Collection|Avis[]
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setProduit($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->contains($avi)) {
            $this->avis->removeElement($avi);
            // set the owning side to null (unless already changed)
            if ($avi->getProduit() === $this) {
                $avi->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProduitCommande[]
     */
    public function getProduitCommandes(): Collection
    {
        return $this->produitCommandes;
    }

    public function addProduitCommande(ProduitCommande $produitCommande): self
    {
        if (!$this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes[] = $produitCommande;
            $produitCommande->setProduit($this);
        }

        return $this;
    }

    public function removeProduitCommande(ProduitCommande $produitCommande): self
    {
        if ($this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes->removeElement($produitCommande);
            // set the owning side to null (unless already changed)
            if ($produitCommande->getProduit() === $this) {
                $produitCommande->setProduit(null);
            }
        }

        return $this;
    }
}
