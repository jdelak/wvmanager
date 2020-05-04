<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

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
    public function buyPlayer(Player $player, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();
        $team = $user->getTeam();
        $price = $player->getBuyingPrice();
        $userMoney = $user->getMoney();

        if($player){

            if($user->getMoney() < $price ){
                $this->addFlash('error', "You haven\'t enough money to buy this player !");
                return $this->redirectToRoute('transfer');
            }else{
                
                $user->setMoney($userMoney - $price);
                $team->addPlayer($player);
                $em->flush();
                $this->addFlash('success', $player->getFullName().'has been added to your team');
                return $this->redirectToRoute('transfer');
            }   

        }else{
            $this->addFlash('error', 'Sorry player is not found or has been bought by another player !');
            return $this->redirectToRoute('transfer');
        }
       

    }
}
