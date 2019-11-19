<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EstimationRepository")
 * @Vich\Uploadable
 */
class Estimation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Specialite", inversedBy="estimations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialite;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SousSpecialite")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sousSpecialite;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;
    /**
     * @ORM\Column(type="boolean")
     */
    private $valider;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeBien;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $debutTravaux;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addresse;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codepostal;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AttributAddRep", mappedBy="estimation")
     */
    private $attributAddReps;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="estimations")
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;
/**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;
/**
     * @Assert\File(
     *     maxSizeMessage = "L'image ne doit pas dépasser 10Mb.",
     *     maxSize = "10024k",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Les images doivent être au format JPG, GIF ou PNG."
     * )
     * @Vich\UploadableField(mapping="estimation_image", fileNameProperty="image")
     */
    private $fichierImage;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Affectation", mappedBy="estimation", cascade={"persist", "remove"})
     */
    private $affectation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\AffectationConfirme", mappedBy="estimation", cascade={"persist", "remove"})
     */
    private $affectationConfirme;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ArtisanEtat", mappedBy="estimation", cascade={"persist", "remove"})
     */
    private $artisanEtat;

    public function __construct()
    {
        $this->attributAddReps = new ArrayCollection();
        $this->sousSpecialite = new ArrayCollection();
        $this->dateEn = new \DateTime();
        $this->valider = false;

    }
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $fichierImage
     *
     * @return Estimation
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

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialite $specialite): self
    {
        $this->specialite = $specialite;

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

    public function getTypeBien(): ?string
    {
        return $this->typeBien;
    }

    public function setTypeBien(string $typeBien): self
    {
        $this->typeBien = $typeBien;

        return $this;
    }

    public function getDebutTravaux(): ?string
    {
        return $this->debutTravaux;
    }

    public function setDebutTravaux(string $debutTravaux): self
    {
        $this->debutTravaux = $debutTravaux;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(?string $addresse): self
    {
        $this->addresse = $addresse;

        return $this;
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

    public function getCodepostal(): ?string
    {
        return $this->codepostal;
    }

    public function setCodepostal(string $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * @return Collection|AttributAddRep[]
     */
    public function getAttributAddReps(): Collection
    {
        return $this->attributAddReps;
    }

    public function addAttributAddRep(AttributAddRep $attributAddRep): self
    {
        if (!$this->attributAddReps->contains($attributAddRep)) {
            $this->attributAddReps[] = $attributAddRep;
            $attributAddRep->setEstimation($this);
        }

        return $this;
    }

    public function removeAttributAddRep(AttributAddRep $attributAddRep): self
    {
        if ($this->attributAddReps->contains($attributAddRep)) {
            $this->attributAddReps->removeElement($attributAddRep);
            // set the owning side to null (unless already changed)
            if ($attributAddRep->getEstimation() === $this) {
                $attributAddRep->setEstimation(null);
            }
        }

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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getAffectation(): ?Affectation
    {
        return $this->affectation;
    }

    public function setAffectation(?Affectation $affectation): self
    {
        $this->affectation = $affectation;

        // set (or unset) the owning side of the relation if necessary
        $newEstimation = $affectation === null ? null : $this;
        if ($newEstimation !== $affectation->getEstimation()) {
            $affectation->setEstimation($newEstimation);
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
        $newEstimation = $affectationConfirme === null ? null : $this;
        if ($newEstimation !== $affectationConfirme->getEstimation()) {
            $affectationConfirme->setEstimation($newEstimation);
        }

        return $this;
    }

    public function __toString()
    {
        return "".$this->getId();
    }

    public function getArtisanEtat(): ?ArtisanEtat
    {
        return $this->artisanEtat;
    }

    public function setArtisanEtat(?ArtisanEtat $artisanEtat): self
    {
        $this->artisanEtat = $artisanEtat;

        // set (or unset) the owning side of the relation if necessary
        $newEstimation = $artisanEtat === null ? null : $this;
        if ($newEstimation !== $artisanEtat->getEstimation()) {
            $artisanEtat->setEstimation($newEstimation);
        }

        return $this;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image=null): self
    {
        $this->image = $image;

        return $this;
    }

}
