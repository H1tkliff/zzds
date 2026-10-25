<?php

namespace App\Controller\Team;

use App\Entity\Team;
use App\Repository\TeamRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cs2', name: 'cs2_')]
final class TeamController extends AbstractController
{
    #[Route('/teams', name: 'team_list')]
    public function index(TeamRepository $repo): Response
    {
        return $this->render('/page/teams/index.html.twig', [
            'teams' => $repo->findAll(),
        ]);
    }

    #[Route('/team/{id}-{slug}', name: 'team_show', requirements: ['id' => '\d+'])]
    public function showTeam(#[MapEntity(id: 'id')] Team $team, string $slug): Response
    {
        if ($slug !== $team->getSlug()) {
            return $this->redirectToRoute('cs2_team_show',
                ['id' => $team->getId(), 'slug' => $team->getSlug(),
                ], Response::HTTP_MOVED_PERMANENTLY
            );
        }

        return $this->render('page/teams/show.html.twig', [
            'team' => $team,
        ]);
    }
}
