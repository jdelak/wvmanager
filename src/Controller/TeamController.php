<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Player;
use App\Entity\Ethnicity;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use App\Repository\LeagueRepository;
use App\Repository\EthnicityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/team")
 */
class TeamController extends AbstractController
{
    protected $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;

    }

    /**
     * @Route("/", name="team_index", methods={"GET"})
     */
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="team_new", methods={"GET","POST"})
     */
    public function new(Request $request, LeagueRepository $leagueRepository, EthnicityRepository $ethnicityRepository): Response
    {
        //verify if user is log
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        //get the last league to set the team league
        $lastLeague = $leagueRepository->findLastLeague(15);

        $teamImagePath = $this->parameterBag->get('kernel.project_dir') . '/public/images/teams/'; 
        $teamImages = array_diff(scandir($teamImagePath), array('..', '.'));
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $team->setImage($_POST['image']);
            $team->setIdUser($user);
            $team->setIdLeague($lastLeague);
            
            $entityManager->persist($team);
            $entityManager->flush();
            $user->setFirstLogin(false);
            $entityManager->persist($user);
            $entityManager->flush();
            

            $ethnicities = $ethnicityRepository->findAll();
            //create middle blockers
            for($i=0; $i < 3; $i++){
                $randomEthnicity = $ethnicities[mt_rand(0, count($ethnicities) -1)];
                $this->generateInitialPlayer($randomEthnicity, 'middle_blocker', $team);  
            }
            //create liberos
            for($j=0; $j < 2; $j++){
                $randomEthnicity = $ethnicities[mt_rand(0, count($ethnicities) -1)];
                $this->generateInitialPlayer($randomEthnicity, 'libero', $team);  
            }
            //create opposites
            for($k=0; $k < 2; $k++){
                $randomEthnicity = $ethnicities[mt_rand(0, count($ethnicities) -1)]; 
                $this->generateInitialPlayer($randomEthnicity, 'opposite', $team);  
            }
            //create outside hitters
            for($l=0; $l < 3; $l++){
                $randomEthnicity = $ethnicities[mt_rand(0, count($ethnicities) -1)];
                $this->generateInitialPlayer($randomEthnicity, 'outside_hitter', $team);  
            }
            //create setters
            for($m=0; $m < 2; $m++){
                $randomEthnicity = $ethnicities[mt_rand(0, count($ethnicities) -1)];
                $this->generateInitialPlayer($randomEthnicity, 'setter', $team);  
            }


            return $this->redirectToRoute('team_index');
        }

        return $this->render('team/new.html.twig', [
            'team' => $team,
            'teamImages' => $teamImages,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_show", methods={"GET"})
     */
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="team_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Team $team): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);
        $teamImagePath = $this->parameterBag->get('kernel.project_dir') . '/public/images/teams/'; 
        $teamImages = array_diff(scandir($teamImagePath), array('..', '.'));

        if ($form->isSubmitted() && $form->isValid()) {
            $team->setImage($_POST['image']);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('team_index');
        }

        return $this->render('team/edit.html.twig', [
            'team' => $team,
            'teamImages' => $teamImages,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Team $team): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('team_index');
    }

    //Create the players with team creation
    public function generateInitialPlayer(Ethnicity $ethnicity, $position, Team $team){

        $player = new Player();
        
        $player->setIdEthnicity($ethnicity);
        $player->setPosition($position);
        $player->setIdTeam($team);
        //Name generation
        $ethnicityName = $ethnicity->getName();
        $generatedName = $player->generateNames($ethnicityName);
        $firstname = $generatedName[0];
        $lastname = $generatedName[1];
        $player->setFirstname($firstname);
        $player->setLastname($lastname);

        $attack = rand(20,25);
        $block = rand(20,25);
        $dig = rand (20,25);
        $passing = rand (20,25);
        $serve = rand (20,25);

        //Stats Generation
        if($position == "outside_hitter"){
            $attack = rand(25,30);
            $dig = rand(25,30);
        }else if($position == "middle_blocker"){
            $block = rand(30,35);
        }else if($position == "opposite"){
            $attack = rand(30,35);
        }else if($position == "libero"){
            $dig = rand(30,35);
        }else if($position == 'setter'){
            $passing = rand(30,35);
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
        $player->setInSquad(false);
        $player->setIsSubstitute(false);
        $player->setIsInjured(false);
        $player->setIsRetired(false);
        
        //Save the player
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($player);
        $team->addPlayer($player);
        $entityManager->flush();
    }

    private function generateImagePlayer($ethnicity){

        $ethnicity = strtolower($ethnicity);
        $ethnicity = str_replace(' ', '', $ethnicity);
        $imageSRC = $ethnicity."-".rand(1,5)."-".rand(1,5).".gif";

        return $imageSRC; 
    }
}
