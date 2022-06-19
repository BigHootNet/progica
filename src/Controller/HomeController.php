<?php
namespace App\Controller;

use App\Entity\Gite;
use App\Entity\User;
use App\Form\UserType;
use App\Entity\Contact;

use App\Form\ContactType;
use App\Entity\GiteSearch;
use App\Form\GiteSearchType;
use App\Notification\ContactNotification;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController {


    /**
     * @Route("/", name="home_index")
     *
     * @param ManagerRegistry $doctrine
     * @return void
     */
    public function index(ManagerRegistry $doctrine, Request $request)
    {

        $search = new GiteSearch();
        // Création du formulaire de recherche
        $form = $this->createForm(GiteSearchType::class, $search);
        $form->handleRequest($request);

        /** @var GiteRepository $repository */
        $repository = $doctrine->getRepository(Gite::class);
        $gites = $repository->findAll();

        if($form->isSubmitted())
        {
            $gites = $repository->findGiteSearch($search);
        }


        return $this->render('home/index.html.twig', [
            "menu" => "home",
            "gites" => $gites,
            "form" => $form->createView()
    ]);
    }
    /**
     * @Route("/contact", name="home_contact")
     */
    public function contact(Request $request, ContactNotification $notification)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $notification->contactNotify($contact);
            $this->addFlash('success', 'Email envoyé!');
        }

        return $this->render('home/contact.html.twig', [
            "menu" => "contact",
            "form" => $form->createView()
    ]);
    }
}