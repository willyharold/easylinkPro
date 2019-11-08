<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AffectationRepository")
 */
class Affectation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Annonce", inversedBy="affectation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $annonce;


    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEn;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="affectations")
     */
    private $artisan;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Estimation", inversedBy="affectation", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $estimation;
    public function __toString()
    {
        return $this->id;
    }
    public function __construct()
    {
        $this->artisan = new ArrayCollection();
        $this->dateEn = new \DateTime();
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


    public function getDateEn(): ?\DateTimeInterface
    {
        return $this->dateEn;
    }

    public function setDateEn(\DateTimeInterface $dateEn): self
    {
        $this->dateEn = $dateEn;

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
