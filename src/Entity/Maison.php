<?php

namespace App\Entity;

use App\Repository\MaisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=MaisonRepository::class)
 */
class Maison
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *  @Assert\NotBlank(message=" nomimmob doit etre non vide")
     * @ORM\Column(type="string", length=255)
     */
    private $nomimmob;

    /**
     * @Assert\NotBlank(message=" nom du loyé doit etre non vide")
     * @ORM\Column(type="string", length=255)
     */
    private $nom_loy;

    /**
     * @Assert\NotBlank(message=" cin doit etre non vide")
     * @Assert\Length(
     *                 min= 8,
     *                 max= 8,
     *                 minMessage="8 chiffres recommandés",
     *                 maxMessage="8 chiffres recommandés" )
     * @ORM\Column(type="string", length=8)
     */
    private $cin_loy;

    /**
     * @Assert\NotBlank(message=" tel doit etre non vide")
     * @Assert\Length(
     *                 min= 8,
     *                 max= 8,
     *                 minMessage="8 chiffres recommandés",
     *                 maxMessage="8 chiffres recommandés" )
     * 
     * @ORM\Column(type="string", length=8)
     */
    private $numerotel;


    

    /**
     *  
     * @ORM\Column(type="date")
     */
    private $fin;

    /**
     * @ORM\Column(type="date")
     */
    private $deb;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;










    public function __construct()
    {
        $this->payements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomImmob(): ?string
    {
        return $this->nomimmob;
    }

    public function setNomImmob(string $nomimmob): self
    {
        $this->nomimmob = $nomimmob;

        return $this;
    }

    public function getNomLoy(): ?string
    {
        return $this->nom_loy;
    }

    public function setNomLoy(string $nom_loy): self
    {
        $this->nom_loy = $nom_loy;

        return $this;
    }

    public function getCinLoy(): ?string
    {
        return $this->cin_loy;
    }

    public function setCinLoy(string $cin_loy): self
    {
        $this->cin_loy = $cin_loy;

        return $this;
    }
    public function getNumeroTel(): ?string
    {
        return $this->numerotel;
    }

    public function setNumeroTel(string $numerotel): self
    {
        $this->numerotel = $numerotel;

        return $this;
    }

    public function __toString()
    {
        return $this->nomimmob;
    }



    /**
     * @return Collection<int, Payement>
     */
    public function getPayements(): Collection
    {
        return $this->payements;
    }

    public function addPayement(Payement $payement): self
    {
        if (!$this->payements->contains($payement)) {
            $this->payements[] = $payement;
            $payement->setMaison($this);
        }

        return $this;
    }

    public function removePayement(Payement $payement): self
    {
        if ($this->payements->removeElement($payement)) {
            // set the owning side to null (unless already changed)
            if ($payement->getMaison() === $this) {
                $payement->setMaison(null);
            }
        }

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    public function getDeb(): ?\DateTimeInterface
    {
        return $this->deb;
    }

    public function setDeb(\DateTimeInterface $deb): self
    {
        $this->deb = $deb;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
