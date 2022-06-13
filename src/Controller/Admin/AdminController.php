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
            $this->addFlash('success', 'Votre gite a bien été créé');
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/gite/create.html.twig', [
            "formGite" => $form->createView()
        ]);
    }

    /**
     * @route("/admin/gite/edit/{id}", name="admin_gite_edit")
     */
    public function edit(Gite $gite, Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(GiteType::class, $gite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $doctrine->getManager();
            $em->flush();
            $this->addFlash('success', 'Votre gite a bien été edité');
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/gite/edit.html.twig', [
        "formGite" => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/gite/delete/{id}", name="admin_gite_delete")
     */
    public function delete(Gite $gite, ManagerRegistry $doctrine, Request $request)
    {
        if($this->isCsrfTokenValid("gite_delete". $gite->getId(), $request->request->get('token'))) 
        {
            $em = $doctrine->getManager();
            $em->remove($gite);
            $em->flush();
            $this->addFlash('success', 'Le gite a bien été supprimé');
        }
        else
        {
            $this->addFlash('error', 'Token non valide');
        }
        return $this->redirectToRoute('admin_index');
        
    }
}