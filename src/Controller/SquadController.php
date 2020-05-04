<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Team;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SquadController extends AbstractController
{
    /**
     * @Route("/squad", name="squad")
     */
    public function index(TeamRepository $teamRepository, PlayerRepository $playerRepository)
    {

        $user = $this->getUser();
        $team = $user->getTeam();
        $players = $team->getPlayers();
        $titulaires = $playerRepository->findTitulairesPlayers($team->getId());

        return $this->render('squad/index.html.twig', [
            'controller_name' => 'SquadController',
            'user' => $user,
            'team' => $team,
            'titulaires' => $titulaires,
            'players' => $players
        ]);
    }

    /**
     * @Route("/squad/swap_players", name="swap_players")
     */
    public function swap(Request $request, PlayerRepository $playerRepository, EntityManagerInterface $em)
    {
       
        $player1Id = intval($request->request->get('player1'));
        $player2Id = intval($request->request->get('player2'));
        $player1SquadPosition = $request->request->get('player1SquadPosition');
        $player2SquadPosition = $request->request->get('player2SquadPosition');
        $playerRepo = $playerRepository;
        $player1 = $playerRepo->find($player1Id);
        $player1->setSquadPosition($player2SquadPosition);
        $em->flush();
        $player2 = $playerRepo->find($player2Id);
        $player2->setSquadPosition($player1SquadPosition);
        $em->flush();
        
        $response = new Response(json_encode(array(
            'player1Position' =>  $player1->getSquadPosition()
        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }

    /**
     * @Route("/squad/player_info", name="player_info")
     */
    public function playerInfo(Request $request, PlayerRepository $playerRepository)
    {
        $playerId = intval($request->request->get('playerId'));
        $player = $playerRepository->find($playerId);

        // On spécifie qu'on utilise l'encodeur JSON
        $encoders = [new JsonEncoder()];

        // On instancie le "normaliseur" pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];

        // On instancie le convertisseur
        $serializer = new Serializer($normalizers, $encoders);

        // On convertit en json
        $jsonContent = $serializer->serialize($player, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        // On instancie la réponse
        $response = new Response($jsonContent);

        // On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/squad/sell_player/", name="sell_player")
     */
    public function sellPlayer(Request $request, PlayerRepository $playerRepository, EntityManagerInterface $em){
        
        $user = $this->getUser();
        $team = $user->getTeam();

       $playerId = intval($request->request->get('playerId'));
       $player = $playerRepository->find($playerId);

       if($player->getSquadPosition() > 7){
            $sellPrice = $player->getSellingPrice();
            $userMoney = $user->getMoney();
            $user->setMoney($userMoney + $sellPrice);
            $team->removePlayer($player);
            $em->flush();

            $response = new Response('Your player has been sold !'
            );
        }else{
            $response = new Response(
                'only substitutes and reserves players can be sell !'
            );  
        }

        $response->headers->set('Content-Type', 'text/html; charset=utf-8');
        return $response;
    }
}
