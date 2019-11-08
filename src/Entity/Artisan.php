<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtisanRepository")
 */
class Artisan
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
     * @ORM\Column(type="date")
     */
    private $dateCreateAt;

    /**
     * @ORM\Column(type="bigint")
     */
    private $fiscale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $siren;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone2;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SousSpecialite", inversedBy="artisans")
     */
    private $sousSpecialite;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="artisan", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->sousSpecialite = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->id.' | '.$this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateCreateAt(): ?\DateTimeInterface
    {
        return $this->dateCreateAt;
    }

    public function setDateCreateAt(\DateTimeInterface $dateCreateAt): self
    {
        $this->dateCreateAt = $dateCreateAt;

        return $this;
    }

    public function getFiscale(): ?int
    {
        return $this->fiscale;
    }

    public function setFiscale(int $fiscale): self
    {
        $this->fiscale = $fiscale;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getTelephone2(): ?string
    {
        return $this->telephone2;
    }

    public function setTelephone2(string $telephone2): self
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    /**
     * @return Collection|SousSpecialite[]
     */
    public function getSousSpecialite(): Collection
    {
        return $this->sousSpecialite;
    }

    public function addSousSpecialite(SousSpecialite $sousSpecialite): self
    {
        if (!$this->sousSpecialite->contains($sousSpecialite)) {
            $this->sousSpecialite[] = $sousSpecialite;
        }

        return $this;
    }

    public function removeSousSpecialite(SousSpecialite $sousSpecialite): self
    {
        if ($this->sousSpecialite->contains($sousSpecialite)) {
            $this->sousSpecialite->removeElement($sousSpecialite);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
