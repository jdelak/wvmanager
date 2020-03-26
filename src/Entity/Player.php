<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;

    /**
     * @ORM\Column(type="smallint")
     */
    private $attack;

    /**
     * @ORM\Column(type="smallint")
     */
    private $block;

    /**
     * @ORM\Column(type="smallint")
     */
    private $dig;

    /**
     * @ORM\Column(type="smallint")
     */
    private $passing;

    /**
     * @ORM\Column(type="smallint")
     */
    private $serve;

    /**
     * @ORM\Column(type="smallint")
     */
    private $age;

    /**
     * @ORM\Column(type="smallint")
     */
    private $training_count;

    /**
     * @ORM\Column(name="position", type="string", columnDefinition="enum('libero', 'middle_blocker', 'opposite', 'outside_hitter', 'setter')")
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $in_squad;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_substitute;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_injured;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_retired;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ethnicity", inversedBy="players")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_ethnicity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="players")
     */
    private $id_team;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getBlock(): ?int
    {
        return $this->block;
    }

    public function setBlock(int $block): self
    {
        $this->block = $block;

        return $this;
    }

    public function getDig(): ?int
    {
        return $this->dig;
    }

    public function setDig(int $dig): self
    {
        $this->dig = $dig;

        return $this;
    }

    public function getPassing(): ?int
    {
        return $this->passing;
    }

    public function setPassing(int $passing): self
    {
        $this->passing = $passing;

        return $this;
    }

    public function getServe(): ?int
    {
        return $this->serve;
    }

    public function setServe(int $serve): self
    {
        $this->serve = $serve;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getTrainingCount(): ?int
    {
        return $this->training_count;
    }

    public function setTrainingCount(int $training_count): self
    {
        $this->training_count = $training_count;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

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

    public function getInSquad(): ?bool
    {
        return $this->in_squad;
    }

    public function setInSquad(bool $in_squad): self
    {
        $this->in_squad = $in_squad;

        return $this;
    }

    public function getIsSubstitute(): ?bool
    {
        return $this->is_substitute;
    }

    public function setIsSubstitute(bool $is_substitute): self
    {
        $this->is_substitute = $is_substitute;

        return $this;
    }

    public function getIsInjured(): ?bool
    {
        return $this->is_injured;
    }

    public function setIsInjured(bool $is_injured): self
    {
        $this->is_injured = $is_injured;

        return $this;
    }

    public function getIsRetired(): ?bool
    {
        return $this->is_retired;
    }

    public function setIsRetired(bool $is_retired): self
    {
        $this->is_retired = $is_retired;

        return $this;
    }

    public function getIdEthnicity(): ?Ethnicity
    {
        return $this->id_ethnicity;
    }

    public function setIdEthnicity(?Ethnicity $id_ethnicity): self
    {
        $this->id_ethnicity = $id_ethnicity;

        return $this;
    }

    public function getIdTeam(): ?Team
    {
        return $this->id_team;
    }

    public function setIdTeam(?Team $id_team): self
    {
        $this->id_team = $id_team;

        return $this;
    }
}
