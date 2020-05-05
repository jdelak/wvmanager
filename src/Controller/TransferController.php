<?php

namespace App\Controller;

use App\Entity\Ethnicity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Player;
use App\Repository\EthnicityRepository;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Void_;

class TransferController extends AbstractController
{
    /**
     * @Route("/transfer", name="transfer")
     */
    public function index(PlayerRepository $playerRepository)
    {

        $players = $playerRepository->findAvailablePlayers();
        $user = $this->getUser();
        $team = $user->getTeam();

        return $this->render('transfer/index.html.twig', [
            'user' => $user,
            'team' => $team,
            'players' => $players,
            'controller_name' => 'TransferController',
        ]);
    }

    /**
     * @Route("/buyplayer/{id}", name="buy_player")
     */
    public function buyPlayer(Player $player, EntityManagerInterface $em, PlayerRepository $playerRepository): Response
    {

        $user = $this->getUser();
        $team = $user->getTeam();
        $price = $player->getBuyingPrice();
        $userMoney = $user->getMoney();
        //Use for setting new player squad Position
        $lastTeamPlayer = $playerRepository->findLastSquadPlayer($team->getId());
        $lastPosition = $lastTeamPlayer->getSquadPosition();

        if($player){

            if($user->getMoney() < $price ){
                $this->addFlash('error', "You haven\'t enough money to buy this player !");
                return $this->redirectToRoute('transfer');
            }else{
                
                $user->setMoney($userMoney - $price);
                $team->addPlayer($player);
                $player->setSquadPosition($lastPosition + 1);
                $em->flush();
                $this->addFlash('success', $player->getFullName().'has been added to your team');
                return $this->redirectToRoute('transfer');
            }   

        }else{
            $this->addFlash('error', 'Sorry player is not found or has been bought by another player !');
            return $this->redirectToRoute('transfer');
        }
       

    }

    /**
     * @route("transfer/generate/", name="generate_player")
     */
    public function generate(EthnicityRepository $ethnicityRepository): Void
    {
        $ethnicities = $ethnicityRepository->findAll();
        $randomEthnicity = $ethnicities[mt_rand(0, count($ethnicities) -1)];
        $positions = array("outside_hitter", "opposite", "libero", "setter", "middle_blocker");
        $position = array_rand($positions, 1);
        $this->generatePlayer($randomEthnicity, $position);

    }

    public function generatePlayer(Ethnicity $ethnicity, $position){

        $player = new Player();
        
        $player->setIdEthnicity($ethnicity);
        $player->setPosition($position);
        $player->setIdTeam(null);
        //Name generation
        $ethnicityName = $ethnicity->getName();
        $generatedName = $player->generateNames($ethnicityName);
        $firstname = $generatedName[0];
        $lastname = $generatedName[1];
        $player->setFirstname($firstname);
        $player->setLastname($lastname);
        $player->setSquadPosition(0);
        $attack = rand(25,30);
        $block = rand(25,30);
        $dig = rand (25,30);
        $passing = rand (25,30);
        $serve = rand (25,30);

        //Stats Generation
        if($position == "outside_hitter"){
            $attack = rand(30,35);
            $dig = rand(30,35);
        }else if($position == "middle_blocker"){
            $block = rand(35,40);
        }else if($position == "opposite"){
            $attack = rand(35,40);
        }else if($position == "libero"){
            $dig = rand(35,40);
        }else if($position == 'setter'){
            $passing = rand(35,40);
        }
           
        $player->setAttack($attack);
        $player->setBlock($block);
        $player->setDig($dig);
        $player->setPassing($passing);
        $player->setServe($serve);

        $player->setAge(rand(16,30));
        $player->setTrainingCount(15);
        
        //image generation 
        $playerImage = $this->generateImagePlayer($ethnicity->getName());
        $player->setImage($playerImage);
        $player->setIsInjured(false);
        $player->setIsRetired(false);
        
        //Save the player
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($player);
        $entityManager->flush();
    }

    private function generateImagePlayer($ethnicity){

        $ethnicity = strtolower($ethnicity);
        $ethnicity = str_replace(' ', '', $ethnicity);
        $imageSRC = $ethnicity."-".rand(1,5)."-".rand(1,5).".gif";

        return $imageSRC; 
    }
    
}
