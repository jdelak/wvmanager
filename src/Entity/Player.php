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

    private function getAttackValue($position){

		$attackvalue = $this->getAttack();
		switch($position){
		case 'middle_blocker':
			$attackvalue = round($attackvalue * 0.6);
			break;
		case 'outside_hitter':
			$attackvalue = round($attackvalue * 1.5);
			break;
		case 'opposite':
			$attackvalue = round($attackvalue * 2.2);
			break;
		case 'setter':
			$attackvalue = round($attackvalue * 0.3);
			break;
		case 'libero':
			$attackvalue = round($attackvalue * 0.1);
			break;
		} 

		return $attackvalue;
	}

	//block value by position
	private function getBlockValue($position){

		$blockValue = $this->getBlock();
		switch($position){
		case 'middle_blocker':
			$blockValue = round($blockValue * 2.5);
			break;
		case 'outside_hitter':
			$blockValue =  $blockValue * 1;
			break;
		case 'opposite':
			$blockValue = round($blockValue * 0.8);
			break;
		case 'setter':
			$blockValue = $blockValue * 1;
			break;
		case 'libero':
			$blockValue = round($blockValue * 0.1);
			break;
		} 

		return $blockValue;
	}

	//dig value by position
	private function getDigValue($position){

		$digValue = $this->getDig();
		switch($position){
		case 'middle_blocker':
			$digValue = round($digValue * 0.3);
			break;
		case 'outside_hitter':
			$digValue = round($digValue * 0.8);
			break;
		case  'opposite':
			$digValue = round($digValue * 0.3);
			break;
		case 'setter':
			$digValue = round($digValue * 0.7);
			break;
		case 'libero':
			$digValue = round($digValue * 2.5);
			break;
		} 

		return $digValue;
	}

	//serve value by position
	private function getServeValue($position){

		$serveValue = $this->getServe();
		switch($position){
		case 'middle_blocker':
			$serveValue = round($serveValue * 1.2);
			break;
		case 'outside_hitter':
			$serveValue = round($serveValue * 1.2);
			break;
		case 'opposite':
			$serveValue = round($serveValue * 1.5);
			break;
		case 'setter':
			$serveValue = round($serveValue * 1.5);
			break;
		case 'libero':
			$serveValue = round($serveValue * 0.1);
			break;
		} 

		return $serveValue;
	}

	//passing value by position
	private function getPassingValue($position){

		$passingValue = $this->getPassing();
		switch($position){
		case 'middle_blocker':
			$passingValue = round($passingValue * 0.4);
			break;
		case 'outside_hitter':
			$passingValue = round($passingValue * 0.5);
			break;
		case 'opposite':
			$passingValue = round($passingValue * 0.2);
			break;
		case 'setter':
			$passingValue = round($passingValue * 2.5);
			break;
		case 'libero':
			$passingValue = round($passingValue * 2.2);
			break;
		} 

		return $passingValue;
	}

	//get overall value of player
	public function getOverall() {

		$position = $this->getPosition();
		$overall = round(($this->getAttackValue($position) + $this->getBlockValue($position) + $this->getDigValue($position) + $this->getPassingValue($position) + $this->getServeValue($position)) / 5);
		return $overall;
	}

	public function becomeOlder(){
        $age = $this->getAge();
        if($age > 15 && $age < 40){
            $age++;
            $this->setAge($age);
        }else{
            $this->setIsRetired(true);
        }
	}

	public function getBuyingPrice(){
        
		$age = $this->getAge();
		$position = $this->getPosition();
		$finalPrice = 0;
		$priceByAge = 0;
		$priceByPosition = 0;

		//PriceByAge Bonus
		if($age < 41){
			$priceByAge = 500;
		}
		else if($age < 36){
			$priceByAge = 750;
		}
		else if($age < 31){
			$priceByAge = 1000;
		}
		else if($age < 26){
			$priceByAge = 1500;
		}
		else if($age > 15 && $age < 21){
			$priceByAge = 2000;
		}else{
			$priceByAge = 0;
		}

		//PriceByPositionBonus
		switch($position){
		case 'outside_hitter':
			$priceByPosition = 1500;
			break;
		case 'opposite':
			$priceByPosition = 2000;
			break;
		case 'middle_blocker':
			$priceByPosition = 1000;
			break;
		case 'setter':
			$priceByPosition = 1200;
			break;
		case 'libero':
			$priceByPosition = 750;
			break;

		}

		$finalPrice = round(($priceByAge + $priceByPosition) * $this->getOverall());        
		return $finalPrice;
	}


	public function getSellingPrice(){

		$sellPrice = round($this->getBuyingPrice() / 2);
		return $sellPrice;

	}
}
