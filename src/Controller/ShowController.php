<?php

namespace App\Controller;

use App\Repository\FigureRepository;
use App\Repository\GroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @Route("/show/{slug}", name="show")
     */
    public function show($slug, 
        FigureRepository $figureRepository,
        GroupRepository $groupRepository): Response
    {
        if (!$figure = $figureRepository->findOneBySlug($slug)) {
            return $this->redirectToRoute('home');
        } else {
            $groups = $groupRepository->findByFigure($figure);
            return $this->render('show/index.html.twig', [
                'figure' => $figure,
                'groups'  => $groups,
            ]);
        }  
    }
}
