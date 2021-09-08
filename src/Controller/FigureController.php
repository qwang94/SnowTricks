<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Entity\Media;
use App\Entity\Video;
use App\Form\FigureType;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\FigureRepository;
use App\Service\CommentService;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/figure")
 */
class FigureController extends AbstractController
{
    /**
     * @Route("/new", name="figure_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $figure = new Figure();
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get("media")->getData();
            
            $video = new Video();
            $source = $form->get('videos')->getData();
            $embed_source = str_replace("watch?v=", "embed/", $source);
            $video->setSource($embed_source);

            foreach($images as $image) {
                $extension = $image->guessExtension();
                $file = md5(uniqid()) . '.' . $extension; 
                
                $image->move(
                    $this->getParameter('images_directory'),
                    $file
                );

                $media = new Media();
                $media->setName($file)
                      ->setType($extension);

                $figure->addMedium($media)
                       ->setUser($user)
                       ->setCreatedAt(new DateTime());
            }
            
            $figure->addVideo($video);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($figure);
            $entityManager->flush();

            return $this->redirectToRoute('figure_show', ['slug' => $figure->getSlug()]);
        }

        return $this->renderForm('figure/new.html.twig', [
            'figure' => $figure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{slug}", name="figure_show", methods={"GET|POST"})
     */
    public function show(
        Figure $figure,
        CommentRepository $commentRepository,
        Request $request,
        PaginatorInterface $paginator,
        CommentService $commentService,
        CategoryRepository $categoryRepository
        ): Response
    {   
        $data = $commentRepository->findCommentByFigure($figure);
        $comments = $paginator->paginate(
            $data,
            $request->query->get('page', 1),
            3
        );

        $comment = new Comment();
        $user = $this->getUser();
        
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $commentService->addComment($comment, $figure, $user);

            $this->redirectToRoute('figure_show', ['slug' => $figure->getSlug()]);
        }

        if (!$figure) {
            return $this->redirectToRoute('home');
        } else {
            $category = $categoryRepository->findByFigure($figure);
            return $this->render('figure/show.html.twig', [
                'form'  => $form->createView(),
                'figure' => $figure,
                'comments' => $comments,
                'categories'  => $category,
            ]);
        }  
    }

    /**
     * @Route("/{id}/edit", name="figure_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Figure $figure): Response
    {
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get("media")->getData();
            
            $video = new Video();
            $source = $form->get('videos')->getData();
            $embed_source = str_replace("watch?v=", "embed/", $source);
            $video->setSource($embed_source);
            
            foreach($images as $image) {
                $extension = $image->guessExtension();
                $file = md5(uniqid()) . '.' . $extension; 
                
                $image->move(
                    $this->getParameter('images_directory'),
                    $file
                );

                $media = new Media();
                $media->setName($file)
                      ->setType($extension);
                $figure->addMedium($media)
                       ->setUser($user)
                       ->setUpdatedAt(new DateTIme());
            }
            $figure->addVideo($video);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('figure_show', ['slug' => $figure->getSlug()]);
        }

        return $this->renderForm('figure/edit.html.twig', [
            'figure' => $figure,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="figure_delete", methods={"POST"}, requirements={"id":"\d+"} )
     */
    public function delete(Request $request, Figure $figure): Response
    {
        if ($this->isCsrfTokenValid('delete'.$figure->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($figure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/delete-image/{id}", name="delete_image", methods={"DELETE"})
     */
    public function deleteImage(Media $image, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        // Verify is token is valid
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])) {
            $name = $image->getName();
            // Delete file from the directory
            unlink($this->getParameter('images_directory').'/'.$name);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();

            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalid'], 400);
        }
    }
}
