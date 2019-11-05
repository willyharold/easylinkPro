<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtisanEtatRepository")
 */
class ArtisanEtat
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
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $artisan;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Annonce", inversedBy="artisanEtat")
     */
    private $annonce;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Estimation", inversedBy="artisanEtat")
     */
    private $estimation;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getArtisan(): ?User
    {
        return $this->artisan;
    }

    public function setArtisan(?User $artisan): self
    {
        $this->artisan = $artisan;

        return $this;
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

    public function getEstimation(): ?Estimation
    {
        return $this->estimation;
    }

    public function setEstimation(?Estimation $estimation): self
    {
        $this->estimation = $estimation;

        return $this;
    }

    public function __construct()
    {
        $this->etat = "En attente";

    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return ''.$this->etat;
    }


}
