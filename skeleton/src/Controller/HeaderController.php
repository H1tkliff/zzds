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
        return $this->render('page/global/header.html.twig', [
            'disciplines' => $this->disciplineRepository->findAll(),
        ]);
    }
}
