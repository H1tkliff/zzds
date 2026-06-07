<?php

namespace App\Controller;

use App\Repository\DisciplineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HeaderController extends AbstractController
{
    public function __construct(private DisciplineRepository $disciplineRepository)
    {
    }

    public function header(): Response
    {
        return $this->render('page/global/header/header.html.twig', [
            'nav_links' => [
                ['label' => 'Matches', 'route' => 'discipline_cs2', 'active' => true],
                ['label' => 'Rankings', 'route' => 'discipline_cs2'],
                ['label' => 'Teams', 'route' => 'team_list'],
                ['label' => 'Players', 'route' => 'discipline_cs2'],
                ['label' => 'Events', 'route' => 'discipline_cs2'],
                ['label' => 'Stats', 'route' => 'discipline_cs2'],
                ['label' => 'News', 'route' => 'discipline_cs2'],
            ],
            'disciplines' => [
                ['label' => 'CS2', 'active' => true],
                ['label' => 'Hearthstone'],
                ['label' => 'Valorant'],
            ],
            'ticker_items' => [
                ['teams' => 'NaVi vs Astralis', 'score' => '14 – 11', 'map' => 'Mirage · Map 2'],
                ['teams' => 'FaZe vs Vitality', 'score' => '7 – 9', 'map' => 'Inferno · Map 1'],
                ['teams' => 'G2 vs MOUZ', 'score' => '16 – 8', 'map' => 'Nuke · FINISHED'],
                ['teams' => 'Cloud9 vs ENCE', 'score' => '3 – 5', 'map' => 'Anubis · Map 3'],
            ],
        ]);
    }
}
