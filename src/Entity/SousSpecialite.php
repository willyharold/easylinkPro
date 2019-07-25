<?php

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SousSpecialiteRepository")
 */
class SousSpecialite
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
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $desCourte;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $desLongue;

    /**
     * @ORM\OneToOne(targetEntity="App\Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Specialite", inversedBy="sousSpecialites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialite;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Artisan", mappedBy="sousSpecialite")
     */
    private $artisans;



    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->artisans = new ArrayCollection();
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

    public function getDesCourte(): ?string
    {
        return $this->desCourte;
    }

    public function setDesCourte(string $desCourte): self
    {
        $this->desCourte = $desCourte;

        return $this;
    }

    public function getDesLongue(): ?string
    {
        return $this->desLongue;
    }

    public function setDesLongue(string $desLongue): self
    {
        $this->desLongue = $desLongue;

        return $this;
    }

    public function getImage(): ?Media
    {
        return $this->image;
    }

    public function setImage(Media $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialite $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function __toString()
    {
        return "".$this->getNom();
    }

    /**
     * @return Collection|Artisan[]
     */
    public function getArtisans(): Collection
    {
        return $this->artisans;
    }

    public function addArtisan(Artisan $artisan): self
    {
        if (!$this->artisans->contains($artisan)) {
            $this->artisans[] = $artisan;
            $artisan->addSousSpecialite($this);
        }

        return $this;
    }

    public function removeArtisan(Artisan $artisan): self
    {
        if ($this->artisans->contains($artisan)) {
            $this->artisans->removeElement($artisan);
            $artisan->removeSousSpecialite($this);
        }

        return $this;
    }


}
