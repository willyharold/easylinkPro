<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieBlogRepository")
 */
class CategorieBlog
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
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleBlog", mappedBy="categorieBlog", orphanRemoval=true)
     */
    private $articleBlogs;

    public function __construct()
    {
        $this->articleBlogs = new ArrayCollection();
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

    /**
     * @return Collection|ArticleBlog[]
     */
    public function getArticleBlogs(): Collection
    {
        return $this->articleBlogs;
    }

    public function addArticleBlog(ArticleBlog $articleBlog): self
    {
        if (!$this->articleBlogs->contains($articleBlog)) {
            $this->articleBlogs[] = $articleBlog;
            $articleBlog->setCategorieBlog($this);
        }

        return $this;
    }

    public function removeArticleBlog(ArticleBlog $articleBlog): self
    {
        if ($this->articleBlogs->contains($articleBlog)) {
            $this->articleBlogs->removeElement($articleBlog);
            // set the owning side to null (unless already changed)
            if ($articleBlog->getCategorieBlog() === $this) {
                $articleBlog->setCategorieBlog(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return "".$this->getTitre();
    }


}

