<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\FigureRepository;
use App\Repository\GroupRepository;
use App\Service\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @Route("/show/{slug}", name="show")
     */
    public function show($slug, 
        FigureRepository $figureRepository,
        GroupRepository $groupRepository,
        CommentService $commentService,
        CommentRepository $commentRepository,
        Request $request): Response 
    {   
        $figure = $figureRepository->findOneBySlug($slug);
        $comments = $commentRepository->findCommentByFigure($figure);

        $comment = new Comment();
        $user = $this->getUser();
        
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $commentService->addComment($comment, $figure, $user);

            $this->redirectToRoute('show', ['slug' => $figure->getSlug()]);
        }

        if (!$figure) {
            return $this->redirectToRoute('home');
        } else {
            $groups = $groupRepository->findByFigure($figure);
            return $this->render('show/index.html.twig', [
                'form'  => $form->createView(),
                'figure' => $figure,
                'comments' => $comments,
                'groups'  => $groups,
            ]);
        }  
    }
}
