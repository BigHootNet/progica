<?php

namespace App\Controller;

use App\Entity\Gite;
use App\Form\GiteType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GiteController extends AbstractController
{
    /**
     * @Route("/gite/{id}", name="gite_show")
     */
    public function show(Gite $gite)
    {

        return $this->render('gite/show.html.twig', [
            "menu" => "gite",
            "gite" => $gite
        ]);
    }

}
