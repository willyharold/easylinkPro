<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnnonceRepository")
 */
class Annonce
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codePostale;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnreg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;
    /**
     * @ORM\Column(type="boolean")
     */
    private $valider;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SousSpecialite")
     */
    private $sousSpectialite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="annonces")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="annonce", cascade={"persist", "remove"})
     */
    private $artisan;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Affectation", mappedBy="annonce", cascade={"persist", "remove"})
     */
    private $affectation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\AffectationConfirme", mappedBy="annonce", cascade={"persist", "remove"})
     */
    private $affectationConfirme;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ArtisanEtat", mappedBy="annonce", cascade={"persist", "remove"})
     */
    private $artisanEtat;
    public function __toString()
    {
        return $this->id.' | '.$this->description;
    }
    public function __construct()
    {
        $this->sousSpectialite = new ArrayCollection();
        $this->dateEnreg = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getCodePostale(): ?string
    {
        return $this->codePostale;
    }

    public function setCodePostale(string $codePostale): self
    {
        $this->codePostale = $codePostale;

        return $this;
    }

    public function getDateEnreg(): ?\DateTimeInterface
    {
        return $this->dateEnreg;
    }

    public function setDateEnreg(\DateTimeInterface $dateEnreg): self
    {
        $this->dateEnreg = $dateEnreg;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getValider(): ?bool
    {
        return $this->valider;
    }

    public function setValider(bool $valider): self
    {
        $this->valider = $valider;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getArtisan(): ?User
    {
        return $this->artisan;
    }

    public function setArtisan(?User $artisan): self
    {
        $this->artisan = $artisan;

        return $this;
    }

    public function getAffectation(): ?Affectation
    {
        return $this->affectation;
    }

    public function setAffectation(?Affectation $affectation): self
    {
        $this->affectation = $affectation;

        // set (or unset) the owning side of the relation if necessary
        $newAnnonce = $affectation === null ? null : $this;
        if ($newAnnonce !== $affectation->getAnnonce()) {
            $affectation->setAnnonce($newAnnonce);
        }

        return $this;
    }

    /**
     * @return Collection|SousSpecialite[]
     */
    public function getSousSpectialite(): Collection
    {
        return $this->sousSpectialite;
    }

    public function addSousSpectialite(SousSpecialite $sousSpectialite): self
    {
        if (!$this->sousSpectialite->contains($sousSpectialite)) {
            $this->sousSpectialite[] = $sousSpectialite;
        }

        return $this;
    }

    public function removeSousSpectialite(SousSpecialite $sousSpectialite): self
    {
        if ($this->sousSpectialite->contains($sousSpectialite)) {
            $this->sousSpectialite->removeElement($sousSpectialite);
        }

        return $this;
    }

    public function getAffectationConfirme(): ?AffectationConfirme
    {
        return $this->affectationConfirme;
    }

    public function setAffectationConfirme(?AffectationConfirme $affectationConfirme): self
    {
        $this->affectationConfirme = $affectationConfirme;

        // set (or unset) the owning side of the relation if necessary
        $newAnnonce = $affectationConfirme === null ? null : $this;
        if ($newAnnonce !== $affectationConfirme->getAnnonce()) {
            $affectationConfirme->setAnnonce($newAnnonce);
        }

        return $this;
    }

    public function getArtisanEtat(): ?ArtisanEtat
    {
        return $this->artisanEtat;
    }

    public function setArtisanEtat(?ArtisanEtat $artisanEtat): self
    {
        $this->artisanEtat = $artisanEtat;

        // set (or unset) the owning side of the relation if necessary
        $newAnnonce = $artisanEtat === null ? null : $this;
        if ($newAnnonce !== $artisanEtat->getAnnonce()) {
            $artisanEtat->setAnnonce($newAnnonce);
        }

        return $this;
    }

}
