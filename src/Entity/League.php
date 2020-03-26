<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LeagueRepository")
 */
class League
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $level;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $pts_to_up;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $pts_to_down;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\League")
     */
    private $id_parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Team", mappedBy="id_division")
     */
    private $teams;


    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getPtsToUp(): ?int
    {
        return $this->pts_to_up;
    }

    public function setPtsToUp(?int $pts_to_up): self
    {
        $this->pts_to_up = $pts_to_up;

        return $this;
    }

    public function getPtsToDown(): ?int
    {
        return $this->pts_to_down;
    }

    public function setPtsToDown(?int $pts_to_down): self
    {
        $this->pts_to_down = $pts_to_down;

        return $this;
    }

    public function getIdParent(): ?self
    {
        return $this->id_parent;
    }

    public function setIdParent(?self $id_parent): self
    {
        $this->id_parent = $id_parent;

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setIdLeague($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            // set the owning side to null (unless already changed)
            if ($team->getIdLeague() === $this) {
                $team->setIdLeague(null);
            }
        }

        return $this;
    }

    
}
