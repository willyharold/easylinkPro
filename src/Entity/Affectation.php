<?php

namespace App\Entity;

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
     */
    private $annonce;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $artisan1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $artisan2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $artisan3;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEn;

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

    public function getArtisan1(): ?User
    {
        return $this->artisan1;
    }

    public function setArtisan1(?User $artisan1): self
    {
        $this->artisan1 = $artisan1;

        return $this;
    }

    public function getArtisan2(): ?User
    {
        return $this->artisan2;
    }

    public function setArtisan2(?User $artisan2): self
    {
        $this->artisan2 = $artisan2;

        return $this;
    }

    public function getArtisan3(): ?User
    {
        return $this->artisan3;
    }

    public function setArtisan3(?User $artisan3): self
    {
        $this->artisan3 = $artisan3;

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
}
