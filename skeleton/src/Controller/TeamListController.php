<?php

namespace App\Controller;

use App\Entity\Team;
use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class TeamListController extends AbstractController
{
    #[Route('/teams', name: 'team_list')]
    public function index(TeamRepository $repo): Response
    {
        return $this->render('teams/index.html.twig', [
            'teams' => $repo->findAll(),
        ]);
    }

    #[Route('/team/{id}', name: 'team_show')]
    public function showTeam(Team $team): Response
    {
        return $this->render('team/index.html.twig', [
            'team' => $team,
        ]);
    }
}