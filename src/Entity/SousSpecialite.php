<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SousSpecialiteRepository")
 * @Vich\Uploadable
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;
/**
     * @Assert\File(
     *     maxSizeMessage = "L'image ne doit pas dépasser 2Mb.",
     *     maxSize = "2048K",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Les images doivent être au format JPG, GIF ou PNG."
     * )
     * @Vich\UploadableField(mapping="sous_specialite_image", fileNameProperty="image")
     */
    private $fichierImage;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Specialite", inversedBy="sousSpecialites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialite;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Artisan", mappedBy="sousSpecialite")
     */
    private $artisans;

/**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateEn;

    public function getDateEn(): ?\DateTimeInterface
    {
        return $this->dateEn;
    }

    public function setDateEn(\DateTimeInterface $dateEn): self
    {
        $this->dateEn = $dateEn;

        return $this;
    }



    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->artisans = new ArrayCollection();
        $this->estimations = new ArrayCollection();
        $this->dateEn = new \DateTime();
    }
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $fichierImage
    */
    public function setFichierImage(File $fichierImage = null)
    {
        $this->fichierImage = $fichierImage;
        if ($fichierImage) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->dateEn = new \DateTime('now');
        }
    }

    public function getFichierImage()
    {
        return $this->fichierImage;
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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
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
