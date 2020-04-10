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
     * @ORM\Column(type="smallint")
     */
    private $squad_position;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="players", cascade={"persist"})
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

    public function getSquadPosition(): ?int
    {
        return $this->squad_position;
    }

    public function setSquadPosition(int $squad_position): self
    {
        $this->$squad_position = $squad_position;

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

    public function generateNames($ethnicityName){

        switch($ethnicityName){

            case 'Blood Elf':
                $firstnames = array(
                    "Aelma","Alada","Amorrel","Amoyn","Aneda","Aulaya", "Aulina","Auni","Aunore","Azadrea","Azaewea","Azlenne","Belwea","Bemarsara","Caerel","Cainaria","Cairea","Ceadine","Ceelenn","Dabnia","Daewe","Darlatha","Daydra","Dayrae","Defia","Deridel","Deyleane","Deythel","Elori","Elylonis","Elymisa","Elysendra","Erili","Eroni","Erosalia","Erosilla", "Fatasia","Firea","Galadra","Galalania","Garna","Gasara","Hanneda","Kalidori","Kalinlania","Kelerae","Kellene","Kinarianna","Kinasa","Kylan","Kyrae","Laewae","Laewea","Lalonis","Lare","Leadori","Lorra","Lynrae","Lysilla","Manara",  "Mirthel",  "Nalinda","Narerae","Narise","Narwea","Novidine","Novilenn","Novivea","Ozara","Sanise","Sasalia","Sedaline","Shana","Sharsalia","Siladel","Silalinda","Silansilla","Syerine","Syrise","Telirae","Telyn","Terea","Terellinda","Tyerin","Tynaria","Tynsia","Vedina","Velalan","Velenna","Venia","Zalina","Zanrea","Zarallatha","Zarion","Zarlanne","Zeadine","Zeadrin","Zearea","Zyandori","Zyarel"
                );
                $names = array(
                    "Ancientbane","Ancientluck","Ancientmind","Arcanemourn","Arcanespear","Autumntrick","Blackbirth","Bloodsmile","Boldforge","Brasssign","Brightdesire","Bronzebeam","Cindergaze","Crimsonbane","Darkband","Darkburst","Dawnsworn","Daybreath","Dayfate","Daysong","Dayspell","Dewbeam","Dewbringer","Dewburn","Dewdepth","Dreadbringer","Dualburn","Dualvale","Dusktrick","Eagerwood","Emberfaith","Emberpath","Embersprinter","Evenflame","Evenshine","Evenstalker","Eventrick","Eversprinter","Firestalker","Flamepost","Glaresmile","Glowburst","Glowtwist","Goldenfate","Goldshine","Goldwood","Greatrest","Greattrick","Grimshade","Grimspark","Hotbinder","Leafbane","Lividdown","Lividfeather","Longtruth","Magesinger","Mirthlight","Mirthtruth","Moonfate","Moonforce","Moonpost","Morningray","Morrowlight","Morrowsworn","Nightfeather","Nightsworn","Nimbleveil","Palepride","Peacebell","Peacehold","Peacesong","Phoenixforce","Phoenixsong","Runereaver","Runesky","Sharpbell","Sharpstar","Silentshadow","Silverpath","Slimflow","Solarseeker","Somberflame","Sombergift","Soultwist","Summerblossom","Sunbane","Sunvein","Sweetflight","Swiftsky","Tindergaze","Tinderheart","Tinderstar","Truehide","Twinthread","Velvetsorrow","Velvetwhisper","Warmblade","Wildsense","Windburst","Windpost"
                );
            break;

            case 'Draenei':
                $names = array(
                    "Aalguni","Aelleall","Aevora","Altaa","Altanora","Avaua","Aveelle","Averah","Avetra","Avgin","Bastra","Binlesia","Bolun","Bomere","Bona","Chega","Chelara","Chemina","Chenah","Cherae","Colana","Durett","Dutaan","Edelle","Edivi","Edmere","Edsa","Egonir","Elna","Eltraa","Enlaara","Ensa","Ereere","Ererin","Esmah","Fanir","Finti","Goraraa","Hafemis","Haleen","Hamere","Inalyn","Inelara","Inemi","Irelaara","Irelun","Iresmena","Irtra","Ishri","Jega","Jesaana","Jolelli","Jolhi","Karae","Kazal","Kazi","Keillyn","Keinir","Keirin","Kelriaad","Khasa","Kihaa","Lunomah","Mahraa","Mahrii","Malii","Mamere","Mela","Miaguni","Milara","Mimae","Miny","Miran","Monaraa","Mosa","Muhmere","Mulesia","Mumena","Murula","Nalaada","Nansia","Nartaa","Nolara","Norasia","Ohuma","Palahula","Phaeall","Remtia","Sehi","Shalei","Thelca","Uraua","Valuette","Xamina","Xataan","Xitaan","Yala","Yami","Zhalii","Zhana"
                );
            break;

            case 'Dwarf':
                $firstnames = array(
                    "Ade","Aemde","Aengras","Airahran","Amdo","Amwaigi","Amwella","Anwhyglo","Arass","Baegohre","Baengri","Bavollon","Bilu","Bratel","Brehrenmu","Bremdua","Bresa","Brinlus","Byglahwu","Bynglehdy","Daeglohto","Dahge","Damvuhgu","Doza","Dungross","Dynvin","Enemlu","Eshe","Gangin","Gannyn","Geanlen","Govo","Gumglistian","Gwalla","Gweyshahvess","Gwonge","Gwytamra","Ihgydiss","Jagess","Jailliss","Jangu","Jelli","Juhge","Kahryta","Kestonn","Kolle","Konrama","Lemgodo","Limiass","Lumwu","Lunann","Lymi","Lyngre","Mahwonli","Marina","Masso","Meynlo","Mogin","Mollunn","Mone","Mynno","Naden","Nashi","Nunli","Nywhygua","Rantemis","Rengi","Rennoss","Resin","Reveze","Ryvou","Saze","Semgali","Seta","Sevewhun","Sili","Sogio","Sugu","Sydymwol","Tagen","Tanthola","Tarou","Teasso","Temwus","Thandamde","Theyma","Thostio","Thumdoshy","Thyhda","Thysess","Twammollu","Twatu","Twesan","Twyhdo","Tyme","Ugyhdo","Usso","Uste","Ymgostan","Yntamu"
                );
                $names = array(
                    "Arcticfield","Barleyheart","Barleymane","Battleback","Battleboot","Blackbeard","Blackbrand","Boldstorm","Boldward","Bonegrace","Bonemantle","Boulderbelcher","Braveaxe","Brightrest","Broadfist","Broadpride","Bronzeforge","Bronzemantle","Coarseblade","Coarsehonor","Coldfield","Cooldrink","Coolfeast","Coolhold","Craggrace","Cragsteel","Darkmail","Deepboot","Doomhelm","Doompike","Drunkguard","Dualgrip","Farbreath","Firecrag","Firstboots","Flintpast","Frostbranch","Frozenkind","Fullback","Fullcrag","Fullgift","Fullnight","Fullpride","Fusedrink","Giantbeer","Giantforce","Giantforge","Goldenfight","Goldnight","Greatkind","Greatmane","Grimfury","Hardfront","Highbrew","Ironbottom","Irongift","Keenarm","Keenbeard","Keenfury","Keenhorn","Kinddepth","Kindhelm","Kindpike","Lastbelly","Longhandle","Longtask","Loudbreath","Loudgate","Madbrew","Madflight","Marbleore","Moltenbelch","Mountainarm","Olddust","Oldfury","Palebreath","Quickdust","Quickfall","Quickmane","Quickpower","Rustgift","Ruststone","Shortshaper","Slateaxe","Smugbelt","Smugfeast","Smugore","Snowtoe","Stoneward","Stouthorn","Strongbrand","Thundergrace","Thunderpower","Toughaxe","Toughroar","Truehold","Twinmane","Twinpride","Warbelcher","Warbrand"
                );
            break;
            
            case 'Human':
                $firstnames = array(
                    "Aiglentina","Ainsley","Akira","Alicia","Alissa","Almuth","Althee","Amabel","Annelie","Aria","Ashley","Audrey","Baerbel","Berenice","Berniss","Blenda","Capucine","Cecile","Cheryl","Ciera","Claudia","Clementine", "Constance","Cornelia","Cynthia","Dayana","Deanna","Debby","Denise","Desideria","Dulce","Ebony","Eila","Eldrida","Elvire","Emmaline","Ericka","Esperanza","Essence","Fay","Florentia","Francena","Galina","Gaya","Gerlindis","Gloriosa","Haylie","Isabel","Iyanna","Jenifer","Jessica","Jewell","Jolantha","Josalyn","Julia","Julissa","Kendal","Lilia","Lillyn","Lydia","Madelina","Madie","Margot","Marie","Mercy","Michele","Millie","Minerva","Mistique","Nastjenka","Norma","Nuria","Olympia","Pascaline","Philippina","Priscila","Rachel","Raffaela","Raquel","Rebeca","Rosanna","Sania","Seraphina","Shahana","Shirley","Sienna","Silka","Sophie","Tamara","Tania","Tempeste","Trista","Vera","Virginia","Vittoria","Voleta","Whitney","Xavierra","Yessenia","Yolanda"
                );
                $names = array(
                   "Alabert","Allerton","Alston","Anderton","Ashton","Atherton","Barlow","Beckwith","Berkeley","Blackwood","Blankley","Boucher","Browning","Buckley","Burton","Carlyle","Cholmondeley","Christiansen","Clemons","Clifford","Clinton","Copeland","Currington","Da Silva","Di Maglia","Dryden","Dupont","Elton","Emsworth","Fiske","Garfield","Garnier","Garthside","Graham","Hallewell","Hampton","Hastings","Hayden","Helton","Hillard","Johnson","Keats","Kendal","Lancaster","Landon","Lee","Lindsey","Mabbott","Malakova","Marlowe","Michallas","Milton","Mitchell","Morton","Newbery","Nutlee","Oldham","Poliakova","Ramires","Ramsay","Ramsey","Reeves","Ridley","Rivers","Rodney","Roscoe","Rutland","Sanchez","Shelby","Sheldon","Shelley","Shurman","Sicilia","Smith","Soames","Southey","Spalding","Spooner","Stafford","Stamper","Stanley","Stevenson","Stonebridge","Stratford","Sutton","Swett","Sydney","Thorne","Thornton","Thorp","Upton","Verone","Villette","Watt","Wheatleigh","Whiteley","Williams","Williamson","Wyther","Yeardley"
                );
            break;

            case 'Night Elf':
                $firstnames = array(
                    "A\'liena","Aethaliynn","Alairan","Alairia","Alariia","Amadrieth","Anyssa","Aryvaria","Becaryn","Belanna","Belylah","Besia","Byatarii","Byaya","Cyriia","E\'rea","E\'reath","Eadyia","Elalania","Elanrena","Eleriala","Emillaeth","Faelyrien","Faenia","Galadya","Galyura","Gathae","Hycina","Idrithil","Ileasia","Ilillaeth","Illilia","Ilywen","Irias","Irlya","Jalaeth","Jersia","Kaedya","Kaenia","Kelanai","Kerai","Keyrai","Kinlia","Kylalas","Kylavanna","Kylylah","Kyrea","Len\'ra","Lyssia","Maedia","Manira","Marralyn","Melarina","Meleae","Meredira","Metarii","Miladya","Mindea","Mylallaes","Mylilaeth","Myssia","Myteaith","Mythalaeas","Myvanna","Nalaei","Nawen","Nelalaes","Nelerias","Nhese","Nilyurea","Nylaria","Nyrya","Nythindia","Relarina","Relrianna","Relterana","Revanna","Rhyarien","Rhyya","Satarre","Selyurae","Sharnea","Shawen","Shenas","Shylyurea","Shyssa","Silenia","Sylia","Tesya","Thaenia","Theanna","Thyn\'ra","Thynya","Trinai","Velthea","Vinaya","Wenyae","Y\'lyssae","Yaraeth","Yllaena"
                );
                $names = array(
                    "Amberwind","Autumnbreeze","Bearsword","Blackbow","Blackspear","Blueblade","Darkarrow","Darksong","Dawndew","Dewbreath","Dewfire","Duskleaf","Evengazer","Farbow","Feathersword","Foghelm","Forestrunner","Foresttree","Greenbreeze","Greencloud","Greenflower","Greenwater","Leaffire","Leaflight","Leafwalker","Leafweaver","Lightflower","Lunabloom","Lunawatcher","Moonblower","Mooncrest","Mossdancer","Mossshot","Mosssword","Nightbow","Nightheart","Nightmight","Oceanwater","Rainblower","Raineye","Rainhelm","Rapidseeker","Rapidwind","Ravenspyre","Ravensword","Sagescribe","Seashade","Seashot","Shadecrest","Shadelight","Shademane","Shadescribe","Shadestar","Shadowbough","Shadowgazer","Shadowtree","Shieldmane","Silentlight","Silentoak","Silentsnow","Silenttree","Silverclouds","Silverspyre","Skygazer","Staghelm","Starshadow","Stillbranch","Stonemane","Stonemoon","Stonerage","Stoneshade","Stronggrove","Strongrunner","Strongshot","Summerarrow","Summerbough","Summerforest","Summertree","Summerwhisper","Sunspirit","Sunwatcher","Swifteye","Swiftshade","Thunderbough","Thundercaller","Thunderforest","Thunderwater","Treebloom","Trueforest","Trueleaf","Truesword","Wildleaf","Wildmight","Winterbough","Winterrunner","Winterwhisper","Woodbreath","Woodcaller","Woodsky","Woodweaver"
                );
            break;

            case 'Orc':
                $firstnames = array (
                    "Ahda","Army","Ary","Arzu","Eletu","Elzoze","Ernas","Erzedku","Ese","Esze","Eze","Famgagkes","Fardu","Fehke","Fesdo","Fultoz\'re","Gahkezo","Gahkiz\'kym","Gala","Gata","Gehky","Gema","Genme","Gomzagte","Goshkangi","Gral\'komte", "Granat","Gremdistra","Greri","Greszu","Grolu","Grota","Gruhlo","Grunam","Grushozdry","Ilori","Kashagtho","Keldera","Keler","Kewto","Koher","Komza","Kone","Kovisa","Mahze","Masgi","Maszem","Mel\'kelgi","Mergendry","Mezu","Mihtut\'re","Mirtu","Mosogki","Mozkosu","Ohly","Ohze","Onmu","Oru","Osam","Osha","Ozutde","Ralam","Rawgi","Relum","Retder","Rihmezta","Rotdar","Rotze","Saduzthym","Sangolky","Sari","Sehmezthu","Sena","Sewe","Shahkagdro","Shehko","Shewzir","Shohkis","Shundum","Shuwte","Sohte","Sona","Sorzyt","Sotu","Sun\'kenme","Sunehne","Sureni","Tadralda","Tehti","Terthela","Terzyr","Tinur","Tiszetrem","Toguma","Tohgogdre","Towy","Zehda","Zilom","Ziwet","Zurnazle"
                );
                $names = array (
                    "Angerbringer","Angerchewer","Angerlock","Axedrums","Axehand","Bitterhand","Blackflesh","Blackhorn","Blackwind","Bloodfall","Brightbattle","Brightslice","Brokenchampion","Bronzechains","Burningstriker","Coldfall","Coldthunder","Cravenfire","Cravenhorn","Cruelchampion","Cruelmarch","Deadbinder","Deadguard","Deathbleeder","Deathtale","Deathwind","Deathwish","Deepthunder","Doombattle","Dragonmaul","Dualbinder","Eagereye","Eagersword","Falseflesh","Firemane","Forerest","Fullbattle","Goresword","Grimcrusher","Grimlaugh","Halfbeast","Halftwist","Hellhand","Hellhunter","Hollowheart","Hollowseeker","Ironforce","Keenbasher","Keenfall","Keenspirit","Laughingchains","Lonebinder","Lonechewer","Madbinder","Madmarch","Nosedeath","Proudbinder","Proudblood","Ragechewer","Ragepack","Rapidfire","Saurdeath","Saurhorn","Shadowdrum","Shadowmight","Sharpmane","Sharpstrike","Sharpstriker","Silenttaker","Skullnight","Skullsteel","Skulltwist","Sourflame","Sourslayer","Starkspite","Starkwolf","Steelblood","Steellash","Steelrest","Steelrunner","Stonetask","Stoutblade","Strongchain","Strongripper","Strongsnarl","Thunderhammer","Tuskedge","Tusksteel","Twinmight","Twinsword","Vengebeast","Vengechain","Viceeye","Warbringer","Warphand","Warpslayer","Warpstriker","Wildfall","Wildpack","Wolfdrums"
                );
            break;

            case 'Tauren':
                $firstnames = array(
                    "Alanne", "Alaqua","Algoma","Atko","Awinita","Baikpe","Blikka","Blonna","Chanigu","Chenoa","Chepuka","Chilam","Cholena","Chumani","Chuvis","Cilgoe","Damtu","Demkavie","Duzo","Eorrowo","Etenia","Eyota","Flapogsqew","Fleeta","Flelgehe","Galilahi","Hehewuti","Hinto","Hisee","Huhongo","Humita","Hune","Hungwa","Ikwoia","Imala","Istas","Izehi","Keezheekoni","Kimi","Kiona","Kuwanlelenta","Kwinno","Kwohee","Luyu","Mahal","Mecha","Medobla","Melgi","Migisi","Mini","Miona","Momkehe","Mongikoia","Mutewoia","Nadie","Natane","Nukpana","Oni","Onida","Onniga","Papina","Pauwau","Pavati","Pekurmi","Powaqa","Pules","Quana","Riblolah","Salali","Shania","Sheshebens","Shiblozi","Sholi","Shopumta","Sillo","Siwa","Sooleawa","Soyala","Sudollee","Tainn","Tamtis","Tawana","Tazanna","Teni","Tittu","Tiye","Tolinka","Udsa","Ulun","Uvelen","Waki","Wauna","Winona","Wurmim","Yamka","Yepa","Zihna","Zikka","Zimoe","Zotkus"
                );
                $names = array(
                    "Autumnbrace","Autumnhoof","Bloodfeather","Bloodseeker","Bloodshadow","Bloodtotem","Chestcut","Clawwatcher","Cloudscar","Crestrider","Darkbend","Dawnjumper","Earthbrace","Earthdreamer","Earthhorn","Emberbinder","Embershout","Firetotem","Flamebreeze","Flatwhisk","Fogblade","Fogbrace","Fogsnout","Freetail","Fullrider","Gloomcutter","Glowwinds","Greatbrace","Hardspear","Hardtail","Hawksinger","Hawkwater","Hazebinder","Hazeshot","Hazewhisk","Hillbend","Ironshadow","Kodostride","Lightbluff","Lighthair","Lightninggrain","Lightningshot","Lightstream","Lightwoods","Loneshout","Longbluff","Mountaincut","Mountainrage","Oatshot","Pinedreamer","Pinepelt","Plaindream","Plaintusk","Proudbend","Prouddream","Proudspear","Pyrecreek","Pyrefeather","Pyretail","Ragewind","Ravenforest","Ravenhorn","Riverfeather","Rivermane","Rockspear","Roughbash","Roughbreath","Roughwind","Rumblebinder","Runescar","Sharpsnout","Singlemoon","Singlerunner","Singlewalker","Singlewhisk","Stonechaser","Stonehide","Strongchaser","Sungrain","Sunsnout","Sunwoods","Swiftrage","Swiftwater","Tallcut","Tallhorn","Tallrunner","Thunderwhisk","Treescar","Treeshot","Treeshout","Truthwound","Twostream","Twowinds","Twowoods","Wheatwater","Windstalker","Wisebreeze","Wisestalker","Youngmoon","Youngsoar"
                );
            break;

            case 'Troll':
                $names = array(
                    "Ah\'ke","Aheiyo","Azmaya","Bo\'ku","Dihozi","Dintenn","Eaz\'ko","Elae","Elah\'ma","Enjaeh","Filli","Fuhsur","Fuwinn","Gehrea","Gucan\'mo","Haenji","Heaz\'di","Heildih","Hi\'jelzu","Hidu","Iah\'ji","Iahro","Ih\'zi","Jan\'tsi","Jeij\'mor","Jeinneja","Jiana","Jiazo\'mo","Ju\'mo","Jundo","Kadon","Kah\'da","Karehlunn","Kaz\'kith","Khahisheth","Kholzi","Khujo","Khuzmor","Kixu","Kul\'mah","Kuzmenn","Lanovu","Lareth","Linde","Loz\'koli","Maehzo","Mantah","Me\'ja","Menti","Noh\'mima","Nol\'tsaeth","Ol\'tse","Ooh\'jeann","Oohzeja","Oon\'zea","Oshmo\'ki","Pah\'ma","Pahdi","Picuz\'joth","Racotho","Rolmu","Rulmi","Sahzenu","Sasezrath","Sathu","Sej\'mu","Shaendu","Shaenjeth","Shaeta","Shil\'zimae","Sho'tseann","Tan\'jenn","Tan\'za","Tela","Tolmivi","Tuh\'ju","Ul\'kuth","Uze","Vaz\'delmu","Vezlo","Vilrah","Viwe","Vulmeiwa","Xendan","Xizenn","Yan\'jia","Yarae","Yethe","Yiceineith","Zemah\'ma","Zhaisozre","Zhecuzri","Zheliar","Zhezmi","Zhoojei","Zhoyol\'zi","Zi\'kea","Zilza","Zilzi","Ziznieh\'du"
                );
            break;
        }

        $generatedName = array();

        if ($ethnicityName == "Draenei" || $ethnicityName == "Troll"){
            $generatedFirstName = "";
        }else{
            $generatedFirstName = $firstnames[mt_rand(0, count($firstnames) -1)];
        }

        $generatedLastName = $names[mt_rand(0, count($names) -1)];

        array_push($generatedName, $generatedFirstName);
        array_push($generatedName, $generatedLastName);

        return $generatedName;
         
    }

}
