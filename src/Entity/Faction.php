<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactionRepository")
 */
class Faction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ethnicity", mappedBy="id_faction")
     */
    private $ethnicities;

    public function __construct()
    {
        $this->ethnicities = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Ethnicity[]
     */
    public function getEthnicities(): Collection
    {
        return $this->ethnicities;
    }

    public function addEthnicity(Ethnicity $ethnicity): self
    {
        if (!$this->ethnicities->contains($ethnicity)) {
            $this->ethnicities[] = $ethnicity;
            $ethnicity->setIdFaction($this);
        }

        return $this;
    }

    public function removeEthnicity(Ethnicity $ethnicity): self
    {
        if ($this->ethnicities->contains($ethnicity)) {
            $this->ethnicities->removeElement($ethnicity);
            // set the owning side to null (unless already changed)
            if ($ethnicity->getIdFaction() === $this) {
                $ethnicity->setIdFaction(null);
            }
        }

        return $this;
    }
}
