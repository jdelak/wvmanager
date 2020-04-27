<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Team;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
}
