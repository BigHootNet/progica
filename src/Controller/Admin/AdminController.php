<?php
namespace App\Controller\Admin;

use App\Entity\Gite;
use App\Form\GiteType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @route("/admin", name="admin_index")
     * 
     */

    public function index(ManagerRegistry $doctrine)
    {   
        $repository = $doctrine->getRepository(Gite::class);
        $gites = $repository->findAll();
        return $this->render("admin/index.html.twig", [
            "menu" => "admin",
            "gites" => $gites
        ]);
    }

        /**
     * @route("/admin/gite/create", name="admin_gite_create")
     */
    public function create(ManagerRegistry $doctrine, Request $request)
    {
        $gite = new Gite();
        $form = $this->createForm(GiteType::class, $gite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $doctrine->getManager();
            $em->persist($gite);
            $em->flush();
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/gite/create.html.twig', [
            "formGite" => $form->createView()
        ]);
    }
}