<?php

namespace App\Controller;

use App\Repository\RankingRepository;
use App\service\RankingChangeResolver;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private RankingRepository $rankingRepository,
        private RankingChangeResolver $rankingChangeResolver
    )
    {}
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->redirectToRoute('discipline_cs2');
    }

    #[Route('/cs2', name: 'discipline_cs2')]
    public function cs2(): Response
    {
        return $this->render('discipline/cs/base.html.twig', [
            'nav_links' => [
                ['label' => 'Matches', 'route' => 'discipline_cs2', 'active' => true],
                ['label' => 'Rankings', 'route' => 'discipline_cs2'],
                ['label' => 'Teams', 'route' => 'cs2/team_list'],
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
            'live_matches' => [
                [
                    'map' => 'Map 2',
                    'team_left' => ['flag' => '🇺🇦', 'name' => 'NaVi'],
                    'team_right' => ['flag' => '🇩🇰', 'name' => 'Astralis'],
                    'score_left' => 14,
                    'score_right' => 11,
                    'win_left' => true,
                    'win_right' => false,
                    'event' => 'ESL Pro League',
                    'format' => 'Bo3 · Mirage',
                ],
                [
                    'map' => 'Map 1',
                    'team_left' => ['flag' => '🇪🇺', 'name' => 'FaZe'],
                    'team_right' => ['flag' => '🇫🇷', 'name' => 'Vitality'],
                    'score_left' => 7,
                    'score_right' => 9,
                    'win_left' => false,
                    'win_right' => true,
                    'event' => 'BLAST Premier',
                    'format' => 'Bo3 · Inferno',
                ],
                [
                    'map' => 'Map 3',
                    'team_left' => ['flag' => '🇷🇺', 'name' => 'Cloud9'],
                    'team_right' => ['flag' => '🇫🇮', 'name' => 'ENCE'],
                    'score_left' => 3,
                    'score_right' => 5,
                    'win_left' => false,
                    'win_right' => true,
                    'event' => 'IEM Cologne',
                    'format' => 'Bo3 · Anubis',
                ],
            ],
            'upcoming_matches' => [
                [
                    'time' => '18:00',
                    'team_left' => ['flag' => '🇩🇪', 'name' => 'MOUZ'],
                    'team_right' => ['flag' => '🇪🇸', 'name' => 'G2'],
                    'event' => 'ESL Pro League',
                    'format' => 'Bo3',
                ],
                [
                    'time' => '20:00',
                    'team_left' => ['flag' => '🇩🇰', 'name' => 'Heroic'],
                    'team_right' => ['flag' => '🇸🇪', 'name' => 'fnatic'],
                    'event' => 'BLAST Premier',
                    'format' => 'Bo1',
                ],
                [
                    'time' => '22:00',
                    'team_left' => ['flag' => '🇺🇸', 'name' => 'Liquid'],
                    'team_right' => ['flag' => '🇧🇷', 'name' => 'FURIA'],
                    'event' => 'IEM Cologne',
                    'format' => 'Bo3',
                ],
            ],
            'rankings' => $this->rankingChangeResolver->getLatestRankingWithChange(),

            'top_players' => [
                ['rank' => 1, 'avatar' => 's1', 'nick' => 's1mple', 'team' => 'NaVi', 'rating' => '1.42'],
                ['rank' => 2, 'avatar' => 'ZW', 'nick' => 'ZywOo', 'team' => 'Vitality', 'rating' => '1.38'],
                ['rank' => 3, 'avatar' => 'NI', 'nick' => 'NiKo', 'team' => 'G2', 'rating' => '1.31'],
                ['rank' => 4, 'avatar' => 'sh', 'nick' => 'sh1ro', 'team' => 'Cloud9', 'rating' => '1.28'],
                ['rank' => 5, 'avatar' => 'BT', 'nick' => 'broky', 'team' => 'FaZe', 'rating' => '1.25'],
            ],
            'upcoming_events' => [
                ['name' => 'IEM Cologne 2025', 'date' => 'Jul 8 – Jul 20', 'prize' => '$1M', 'soon' => true],
                ['name' => 'BLAST Premier Spring', 'date' => 'Jul 14 – Jul 21', 'prize' => '$425K', 'soon' => false],
                ['name' => 'ESL Pro League S20', 'date' => 'Aug 3 – Aug 24', 'prize' => '$850K', 'soon' => false],
            ],
            'platform_stats' => [
                ['val' => '2,841', 'label' => 'Live viewers'],
                ['val' => '14', 'label' => 'Live matches'],
                ['val' => '312', 'label' => 'Teams tracked'],
                ['val' => '4.8K', 'label' => 'Players'],
            ],
        ]);
    }
}
