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
     */
    private $annonce;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="affectationConfirmes")
     */
    private $artisan;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $artisanConfirme;

    public function __construct()
    {
        $this->artisan = new ArrayCollection();
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
}
