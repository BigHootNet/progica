<?php

namespace App\Controller\Admin;

use App\Entity\Equipement;
use App\Form\EquipementType;
use App\Repository\EquipementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/equipement")
 */
class AdminEquipementController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_admin_equipement_index", methods={"GET"})
     */
    public function index(EquipementRepository $equipementRepository): Response
    {
        return $this->render('admin/admin_equipement/index.html.twig', [
            'equipements' => $equipementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_admin_equipement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EquipementRepository $equipementRepository): Response
    {
        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipementRepository->add($equipement, true);

            return $this->redirectToRoute('app_admin_admin_equipement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_equipement/new.html.twig', [
            'equipement' => $equipement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_admin_equipement_show", methods={"GET"})
     */
    public function show(Equipement $equipement): Response
    {
        return $this->render('admin/admin_equipement/show.html.twig', [
            'equipement' => $equipement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_admin_equipement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Equipement $equipement, EquipementRepository $equipementRepository): Response
    {
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipementRepository->add($equipement, true);

            return $this->redirectToRoute('app_admin_admin_equipement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_equipement/edit.html.twig', [
            'equipement' => $equipement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_admin_equipement_delete", methods={"POST"})
     */
    public function delete(Request $request, Equipement $equipement, EquipementRepository $equipementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipement->getId(), $request->request->get('_token'))) {
            $equipementRepository->remove($equipement, true);
        }

        return $this->redirectToRoute('app_admin_admin_equipement_index', [], Response::HTTP_SEE_OTHER);
    }
}
