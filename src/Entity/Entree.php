<?php

namespace App\Entity;

use App\Repository\EntreeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntreeRepository::class)
 */
class Entree
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEntree;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $qteEntree;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="entrees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="entrees")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEntree(): ?\DateTimeInterface
    {
        return $this->dateEntree;
    }

    public function setDateEntree(\DateTimeInterface $dateEntree): self
    {
        $this->dateEntree = $dateEntree;

        return $this;
    }

    public function getQteEntree(): ?string
    {
        return $this->qteEntree;
    }

    public function setQteEntree(string $qteEntree): self
    {
        $this->qteEntree = $qteEntree;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
