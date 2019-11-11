<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleBlogRepository")
 * @Vich\Uploadable
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;
/**
     * @Assert\File(
     *     maxSizeMessage = "L'image ne doit pas dépasser 10Mb.",
     *     maxSize = "10024k",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Les images doivent être au format JPG, GIF ou PNG."
     * )
     * @Vich\UploadableField(mapping="article_image", fileNameProperty="avatar")
     */
    private $avatarImage;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieBlog", inversedBy="articleBlogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorieBlog;
    public function __toString()
    {
        return $this->id.' | '.$this->titre;
    }
    public function __construct()
    {
        $this->dateEn = new \DateTime();
        $this->etat = false;
    }

/**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $avatarImage
     *
     * @return ArticleBlog
    */
    public function setAvatarImage(File $avatarImage = null)
    {
        $this->avatarImage = $avatarImage;
        if ($avatarImage) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->dateEn = new \DateTime('now');
        }
    }

    public function getAvatarImage()
    {
        return $this->avatarImage;
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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}
