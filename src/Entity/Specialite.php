<?php

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecialiteRepository")
 */
class Specialite
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
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $code;

    /**
     * @ORM\OneToOne(targetEntity="App\Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SousSpecialite", mappedBy="specialite")
     */
    private $sousSpecialites;

    public function __construct()
    {
        $this->sousSpecialites = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getImage(): ?Media
    {
        return $this->image;
    }

    public function setImage(?Media $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|SousSpecialite[]
     */
    public function getSousSpecialites(): Collection
    {
        return $this->sousSpecialites;
    }

    public function addSousSpecialite(SousSpecialite $sousSpecialite): self
    {
        if (!$this->sousSpecialites->contains($sousSpecialite)) {
            $this->sousSpecialites[] = $sousSpecialite;
            $sousSpecialite->setSpecialite($this);
        }

        return $this;
    }

    public function removeSousSpecialite(SousSpecialite $sousSpecialite): self
    {
        if ($this->sousSpecialites->contains($sousSpecialite)) {
            $this->sousSpecialites->removeElement($sousSpecialite);
            // set the owning side to null (unless already changed)
            if ($sousSpecialite->getSpecialite() === $this) {
                $sousSpecialite->setSpecialite(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return "".$this->getNom();
    }


}
