<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class HeaderController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
    ) {
    }

    public function header(): Response
    {
        // header() is rendered as an embedded controller (render(controller(...))), so
        // the request routing didn't happen on this sub-request — the current route has
        // to be read off the master request instead.
        $currentRoute = $this->requestStack->getParentRequest()?->attributes->get('_route');

        $disciplines = [
            ['label' => 'CS2', 'slug' => 'cs2', 'active' => true],
            ['label' => 'Hearthstone', 'slug' => 'hearthstone'],
            ['label' => 'Valorant', 'slug' => 'valorant'],
        ];

        $activeDisciplineSlug = 'cs2';
        foreach ($disciplines as $discipline) {
            if (!empty($discipline['active'])) {
                $activeDisciplineSlug = $discipline['slug'];
                break;
            }
        }

        return $this->render('page/global/header/header.html.twig', [
            'nav_links' => [
                // ['label' => 'Matches', 'route' => 'cs2_home'],
                // ['label' => 'Rankings', 'route' => 'cs2_home'],
                ['label' => 'Teams', 'route' => $activeDisciplineSlug.'_team_list'],
                // ['label' => 'Players', 'route' => 'cs2_home'],
                // ['label' => 'Events', 'route' => 'cs2_home'],
                // ['label' => 'Stats', 'route' => 'cs2_home'],
                // ['label' => 'News', 'route' => 'cs2_home'],
            ],
            'current_route' => $currentRoute,
            'disciplines' => $disciplines,
            'ticker_items' => [
                ['teams' => 'NaVi vs Astralis', 'score' => '14 – 11', 'map' => 'Mirage · Map 2'],
                ['teams' => 'FaZe vs Vitality', 'score' => '7 – 9', 'map' => 'Inferno · Map 1'],
                ['teams' => 'G2 vs MOUZ', 'score' => '16 – 8', 'map' => 'Nuke · FINISHED'],
                ['teams' => 'Cloud9 vs ENCE', 'score' => '3 – 5', 'map' => 'Anubis · Map 3'],
            ],
        ]);
    }
}
