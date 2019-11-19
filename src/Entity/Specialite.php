<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecialiteRepository")
 * @Vich\Uploadable
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
     * @Vich\UploadableField(mapping="specialite_image", fileNameProperty="image")
     */
    private $fichierImage;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SousSpecialite", mappedBy="specialite")
     */
    private $sousSpecialites;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Estimation", mappedBy="specialite")
     */
    private $estimations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AttributAdd", mappedBy="specialite", cascade={"all"})
     */
    private $attributAdds;
    /**
     * @ORM\Column(type="datetime", nullable=true)
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
        $this->sousSpecialites = new ArrayCollection();
        $this->estimations = new ArrayCollection();
        $this->attributAdds = new ArrayCollection();
        $this->dateEn = new \DateTime();
    }
/**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $fichierImage
     *
     * @return Specialite
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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

    /**
     * @return Collection|Estimation[]
     */
    public function getEstimations(): Collection
    {
        return $this->estimations;
    }

    public function addEstimation(Estimation $estimation): self
    {
        if (!$this->estimations->contains($estimation)) {
            $this->estimations[] = $estimation;
            $estimation->setSpecialite($this);
        }

        return $this;
    }

    public function removeEstimation(Estimation $estimation): self
    {
        if ($this->estimations->contains($estimation)) {
            $this->estimations->removeElement($estimation);
            // set the owning side to null (unless already changed)
            if ($estimation->getSpecialite() === $this) {
                $estimation->setSpecialite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AttributAdd[]
     */
    public function getAttributAdds(): Collection
    {
        return $this->attributAdds;
    }

    public function addAttributAdd(AttributAdd $attributAdd): self
    {
        if (!$this->attributAdds->contains($attributAdd)) {
            $this->attributAdds[] = $attributAdd;
            $attributAdd->setSpecialite($this);
        }

        return $this;
    }

    public function removeAttributAdd(AttributAdd $attributAdd): self
    {
        if ($this->attributAdds->contains($attributAdd)) {
            $this->attributAdds->removeElement($attributAdd);
            // set the owning side to null (unless already changed)
            if ($attributAdd->getSpecialite() === $this) {
                $attributAdd->setSpecialite(null);
            }
        }

        return $this;
    }


}
