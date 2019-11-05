<?php

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleBlogRepository")
 */
class ArticleBlog
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
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEn;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $datePub;

    /**
     * @ORM\OneToOne(targetEntity="App\Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove"})
     */
    private $avatar;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieBlog", inversedBy="articleBlogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorieBlog;

    public function __construct()
    {
        $this->dateEn = new \DateTime();
        $this->etat = false;
    }



    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

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

    public function getDatePub(): ?\DateTimeInterface
    {
        return $this->datePub;
    }

    public function setDatePub(\DateTimeInterface $datePub): self
    {
        $this->datePub = $datePub;

        return $this;
    }

    public function getCategorieBlog(): ?CategorieBlog
    {
        return $this->categorieBlog;
    }

    public function setCategorieBlog(?CategorieBlog $categorieBlog): self
    {
        $this->categorieBlog = $categorieBlog;

        return $this;
    }

    public function getAvatar(): ?Media
    {
        return $this->avatar;
    }

    public function setAvatar(?Media $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}
