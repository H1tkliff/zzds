<?php

namespace App\Controller;

use App\Repository\DisciplineRepository;
use App\Repository\PlayerRepository;
use App\Service\RankingChangeResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private RankingChangeResolver $rankingChangeResolver,
    ) {
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->redirectToRoute('cs2_home');
    }

    #[Route('/cs2', name: 'cs2_home')]
    public function cs2(DisciplineRepository $disciplines, PlayerRepository $players): Response
    {
        $cs2 = $disciplines->findOneBy(['slug' => 'cs2']) ?? throw $this->createNotFoundException();

        return $this->render('cs2/index.html.twig', [
            'rankings' => $this->rankingChangeResolver->getLatestRankingWithChange($cs2),
            'top_players' => $players->findTopRated($cs2, 5),
            'upcoming_events' => [], // shortcut: no Event entity yet, filled in step 1.2
        ]);
    }
}
