<?php
/**
 * Created by PhpStorm.
 * User: europeonline
 * Date: 29/01/2019
 * Time: 18:06
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="user")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @Vich\Uploadable
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEnreg;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codePostale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

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
     * @Vich\UploadableField(mapping="user_image", fileNameProperty="avatar")
     */
    private $avatarImage;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Annonce", mappedBy="client")
     */
    private $annonces;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Annonce", mappedBy="artisan", cascade={"persist", "remove"})
     */
    private $annonce;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Avis", mappedBy="client")
     *
     */
    private $avis;

    protected $password;

    protected $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $civilite;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Artisan", mappedBy="user", cascade={"persist", "remove"})
     */
    private $artisan;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Affectation", mappedBy="artisan")
     */
    private $affectations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\AffectationConfirme", mappedBy="artisan")
     */
    private $affectationConfirmes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Estimation", mappedBy="client")
     */
    private $estimations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="artisan")
     */
    private $transactions;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->dateEnreg = new \DateTime();
        $this->annonces = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->affectations = new ArrayCollection();
        $this->affectationConfirmes = new ArrayCollection();
        $this->civilite = "HOMME";
        $this->estimations = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->addRole("ROLE_CLIENT");
    }
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $avatarImage
     *
     * @return User
    */
    public function setAvatarImage(File $avatarImage = null)
    {
        $this->avatarImage = $avatarImage;
        if ($avatarImage) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->dateEnreg = new \DateTime('now');
        }
    }

    public function getAvatarImage()
    {
        return $this->avatarImage;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getDateEnreg(): ?\DateTimeInterface
    {
        return $this->dateEnreg;
    }

    public function setDateEnreg(\DateTimeInterface $dateEnreg): self
    {
        $this->dateEnreg = $dateEnreg;

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

    public function getCodePostale(): ?string
    {
        return $this->codePostale;
    }

    public function setCodePostale(string $codePostale): self
    {
        $this->codePostale = $codePostale;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar=null): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setClient($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->contains($annonce)) {
            $this->annonces->removeElement($annonce);
            // set the owning side to null (unless already changed)
            if ($annonce->getClient() === $this) {
                $annonce->setClient(null);
            }
        }

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        // set (or unset) the owning side of the relation if necessary
        $newArtisan = $annonce === null ? null : $this;
        if ($newArtisan !== $annonce->getArtisan()) {
            $annonce->setArtisan($newArtisan);
        }

        return $this;
    }

    /**
     * @return Collection|Avis[]
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setClient($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->contains($avi)) {
            $this->avis->removeElement($avi);
            // set the owning side to null (unless already changed)
            if ($avi->getClient() === $this) {
                $avi->setClient(null);
            }
        }

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getArtisan(): ?Artisan
    {
        return $this->artisan;
    }

    public function setArtisan(?Artisan $artisan): self
    {
        $this->artisan = $artisan;

        // set (or unset) the owning side of the relation if necessary
        $newUser = $artisan === null ? null : $this;
        if ($newUser !== $artisan->getUser()) {
            $artisan->setUser($newUser);
        }

        return $this;
    }

    /**
     * @return Collection|Affectation[]
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectation $affectation): self
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations[] = $affectation;
            $affectation->addArtisan($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): self
    {
        if ($this->affectations->contains($affectation)) {
            $this->affectations->removeElement($affectation);
            $affectation->removeArtisan($this);
        }

        return $this;
    }

    /**
     * @return Collection|AffectationConfirme[]
     */
    public function getAffectationConfirmes(): Collection
    {
        return $this->affectationConfirmes;
    }

    public function addAffectationConfirme(AffectationConfirme $affectationConfirme): self
    {
        if (!$this->affectationConfirmes->contains($affectationConfirme)) {
            $this->affectationConfirmes[] = $affectationConfirme;
            $affectationConfirme->addArtisan($this);
        }

        return $this;
    }

    public function removeAffectationConfirme(AffectationConfirme $affectationConfirme): self
    {
        if ($this->affectationConfirmes->contains($affectationConfirme)) {
            $this->affectationConfirmes->removeElement($affectationConfirme);
            $affectationConfirme->removeArtisan($this);
        }

        return $this;
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
            $estimation->setClient($this);
        }

        return $this;
    }

    public function removeEstimation(Estimation $estimation): self
    {
        if ($this->estimations->contains($estimation)) {
            $this->estimations->removeElement($estimation);
            // set the owning side to null (unless already changed)
            if ($estimation->getClient() === $this) {
                $estimation->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setArtisan($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getArtisan() === $this) {
                $transaction->setArtisan(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->id.' | '.$this->nom;
    }
}