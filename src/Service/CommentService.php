<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class CommentService
{
    private $manager;
    private $flash;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flash)
    {
        $this->manager = $manager;
        $this->flash = $flash;
    }

    public function addComment(Comment $comment, Figure $figure = null, User $user = null): void 
    {
        $comment->setCreatedAt(new DateTime('now'))
                ->setUser($user)
                ->setFigure($figure);
        
        $this->manager->persist($comment);
        $this->manager->flush();
        $this->flash->add('success', 'Votre commentaire a bien été envoyé, merci !');
    }
}