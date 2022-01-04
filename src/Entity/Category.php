<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Cours::class, mappedBy="category", orphanRemoval=true)
     */
    private $Cours;

    public function __construct()
    {
        $this->Cours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Cours[]
     */
    public function getCours(): Collection
    {
        return $this->Cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->Cours->contains($cour)) {
            $this->Cours[] = $cour;
            $cour->setCategory($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->Cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getCategory() === $this) {
                $cour->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
