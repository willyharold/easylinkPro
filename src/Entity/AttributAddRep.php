<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttributAddRepRepository")
 */
class AttributAddRep
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AttributAdd", inversedBy="reponse")
     */
    private $attributAdd;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reponse;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Estimation", inversedBy="attributAddReps")
     */
    private $estimation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttributAdd(): ?AttributAdd
    {
        return $this->attributAdd;
    }

    public function setAttributAdd(?AttributAdd $attributAdd): self
    {
        $this->attributAdd = $attributAdd;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

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
