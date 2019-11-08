<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Beelab\PaypalBundle\Entity\Transaction as BaseTransaction;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction extends BaseTransaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Coupon", inversedBy="transactions")
     */
    private $coupon;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numero;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEn;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pack", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pack;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Abonnement", mappedBy="transaction", cascade={"persist", "remove"})
     */
    private $abonnement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $artisan;
    
    public function __toString()
    {
        return $this->prix.'€ | '.$this->numero;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }

    public function setCoupon(?Coupon $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

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

    public function getPack(): ?Pack
    {
        return $this->pack;
    }

    public function setPack(?Pack $pack): self
    {
        $this->pack = $pack;

        return $this;
    }

    public function getAbonnement(): ?Abonnement
    {
        return $this->abonnement;
    }

    public function setAbonnement(Abonnement $abonnement): self
    {
        $this->abonnement = $abonnement;

        // set the owning side of the relation if necessary
        if ($this !== $abonnement->getTransaction()) {
            $abonnement->setTransaction($this);
        }

        return $this;
    }

    public function getArtisan(): ?User
    {
        return $this->artisan;
    }

    public function setArtisan(?User $artisan): self
    {
        $this->artisan = $artisan;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->prix;
    }

    public function getItems(): array
    {
        return array();
    }

    public function getShippingAmount(): string
    {
        return '0.00';
    }



}
