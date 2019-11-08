<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AffectationConfirmeRepository")
 */
class AffectationConfirme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Annonce", inversedBy="affectationConfirme", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $annonce;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="affectationConfirmes")
     */
    private $artisan;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $artisanConfirme;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $etat;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Estimation", inversedBy="affectationConfirme")
     * @ORM\JoinColumn(nullable=true)
     */
    private $estimation;
    public function __toString()
    {
        return $this->id.' | '.$this->etat;
    }
    public function __construct()
    {
        $this->artisan = new ArrayCollection();
        $this->etat = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getArtisan(): Collection
    {
        return $this->artisan;
    }

    public function addArtisan(User $artisan): self
    {
        if (!$this->artisan->contains($artisan)) {
            $this->artisan[] = $artisan;
        }

        return $this;
    }

    public function removeArtisan(User $artisan): self
    {
        if ($this->artisan->contains($artisan)) {
            $this->artisan->removeElement($artisan);
        }

        return $this;
    }

    public function getArtisanConfirme(): ?User
    {
        return $this->artisanConfirme;
    }

    public function setArtisanConfirme(?User $artisanConfirme): self
    {
        $this->artisanConfirme = $artisanConfirme;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getEstimation(): ?Estimation
    {
        return $this->estimation;
    }

    public function setEstimation(?Estimation $estimation): self
    {
        $this->estimation = $estimation;

        return $this;
    }
}
