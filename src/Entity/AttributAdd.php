<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttributAddRepository")
 */
class AttributAdd
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Specialite", inversedBy="attributAdds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeRep;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AttributAddRep", mappedBy="attributAdd", cascade={"all"})
     */
    private $attributAddReps;

    public function __construct()
    {
        $this->reponse = new ArrayCollection();
        $this->attributAddReps = new ArrayCollection();
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTypeRep(): ?string
    {
        return $this->typeRep;
    }

    public function setTypeRep(string $typeRep): self
    {
        $this->typeRep = $typeRep;

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
            $attributAddRep->setAttributAdd($this);
        }

        return $this;
    }

    public function removeAttributAddRep(AttributAddRep $attributAddRep): self
    {
        if ($this->attributAddReps->contains($attributAddRep)) {
            $this->attributAddReps->removeElement($attributAddRep);
            // set the owning side to null (unless already changed)
            if ($attributAddRep->getAttributAdd() === $this) {
                $attributAddRep->setAttributAdd(null);
            }
        }

        return $this;
    }

}
