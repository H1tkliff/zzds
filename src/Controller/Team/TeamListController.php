<?php

namespace App\Controller\Team;

use App\Entity\Team;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TeamListController extends AbstractController
{
    #[Route('cs2/teams', name: 'cs2/team_list')]
    public function index(TeamRepository $repo): Response
    {
        return $this->render('/page/teams/index.html.twig', [
            'teams' => $repo->findAll(),
        ]);
    }

    #[Route('/team/{id}', name: 'team_show')]
    public function showTeam(Team $team): Response
    {
        return $this->render('page/team/index.html.twig', [
            'team' => $team,
        ]);
    }
}
