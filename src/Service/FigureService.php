<?php

namespace App\Service;

use App\Entity\Figure;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class FigureService
{
    private $manager;
    private $flash;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flash)
    {
        $this->manager = $manager;
        $this->flash = $flash;
    }

    public function addFigure(Figure $figure, User $user): void 
    {
        $figure->setCreatedAt(new DateTime('now'))
                ->setUser($user);
        
        $this->manager->persist($figure);
        $this->manager->flush();
        $this->flash->add('success', 'Votre figure a bien été uploadé, merci !');
    }
}