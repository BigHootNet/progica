<?php

namespace App\Entity;

use App\Repository\GiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=GiteRepository::class)
 */
class Gite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     * min=5,
     * max=300,
     * minMessage = "La description doit contenir un minimum de {{ min }} caractères",
     * maxMessage = "La description doit contenir un maximum de {{ max }} caractères"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     * min=15,
     * max=3000,
     * minMessage="La valeur minimum est de {{ min }} m²",
     * maxMessage="La valeur maximum est de {{ max }} m²"
     * )
     */
    private $surface;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     * min=1,
     * max=100,
     * minMessage="La valeur minimum est de {{ min }} chambre(s)",
     * maxMessage="La valeur maximum est de {{ max }} chambres"
     * )
     */
    private $chambre;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     * min=1,
     * max=100,
     * minMessage="La valeur minimum est de {{ min }} couchages",
     * maxMessage="La valeur maximum est de {{ max }} couchages"
     * )
     */
    private $couchage;

    /**
     * @ORM\ManyToMany(targetEntity=Equipement::class, inversedBy="gites")
     */
    private $equipements;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Gites")
     */
    private $user;

    public function __construct()
    {
        $this->equipements = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getChambre(): ?int
    {
        return $this->chambre;
    }

    public function setChambre(int $chambre): self
    {
        $this->chambre = $chambre;

        return $this;
    }

    public function getCouchage(): ?int
    {
        return $this->couchage;
    }

    public function setCouchage(int $couchage): self
    {
        $this->couchage = $couchage;

        return $this;
    }

    /**
     * @return Collection<int, Equipement>
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements[] = $equipement;
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): self
    {
        $this->equipements->removeElement($equipement);

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
