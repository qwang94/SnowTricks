<?php

namespace App\Service;

use App\Entity\Figure;
use App\Entity\Media;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FigureService
{
    private $manager;
    private $params;

    public function __construct(
        EntityManagerInterface $manager, 
        ParameterBagInterface $params
        )
    {
        $this->manager = $manager;
        $this->params = $params;
    }

    public function addFigure(Figure $figure, User $user): void 
    {
        $figure->setCreatedAt(new DateTime('now'))
                ->setUser($user);
        
        $this->manager->persist($figure);
        $this->manager->flush();
    }

    public function treatImage(Media $media, $image)
    {
        $extension = $image->guessExtension();
        $file = md5(uniqid()) . '.' . $extension; 

        $image->move(
            $this->params->get('images_directory'),
            $file
        );

        $media->setName($file)
              ->setType($extension);
    }

    public function treatVideo($source)
    {
        $new_source = str_replace("watch?v=", "embed/", $source);

        return $new_source;
    }
}