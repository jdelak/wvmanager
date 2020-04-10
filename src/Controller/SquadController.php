<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Team;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;

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
    public function swap(PlayerRepository $playerRepository)
    {
        //$player1 = $playerRepository->findById($id1);
    }
}
