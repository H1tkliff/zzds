<?php

namespace App\Controller;

use App\Repository\DisciplineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class HeaderController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private DisciplineRepository $disciplineRepository,
    ) {
    }

    public function header(): Response
    {
        // header() is rendered as an embedded controller (render(controller(...))), so
        // the request routing didn't happen on this sub-request — the current route has
        // to be read off the master request instead.
        $currentRoute = (string) $this->requestStack->getParentRequest()?->attributes->get('_route');

        $activeSlug = 'cs2';
        $disciplines = [];

        foreach ($this->disciplineRepository->findAll() as $discipline) {
            $slug = $discipline->getSlug();
            $active = str_starts_with($currentRoute, $slug.'_');
            if ($active) {
                $activeSlug = $slug;
            }

            $disciplines[] = [
                'label' => $discipline->getName(),
                'url' => $this->homeUrl($slug),
                'active' => $active,
            ];
        }

        return $this->render('page/global/header/header.html.twig', [
            'nav_links' => [
                ['label' => 'Teams', 'route' => $activeSlug.'_team_list'],
            ],
            'current_route' => $currentRoute,
            'disciplines' => $disciplines,
        ]);
    }

    // disciplines without their own pages yet (no "<slug>_home" route) are shown as disabled
    private function homeUrl(string $slug): ?string
    {
        try {
            return $this->generateUrl($slug.'_home');
        } catch (RouteNotFoundException) {
            return null;
        }
    }
}
