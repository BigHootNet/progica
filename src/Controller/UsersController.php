<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PwType;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="app_users")
     */
    public function index(): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    /**
     * @Route("/profile", name="user_profile")
     */
    public function editProfile(Request $request, ManagerRegistry $doctrine)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Votre profil à bien été édité');
            return $this->redirectToRoute('app_users');
        }

        return $this->render('home/profile.html.twig', [
            "menu" => "profile",
            "form" => $form->createView()
    ]); 
    }


    /**
     * @Route("/profile/editpassword", name="user_edit_password")
     */
    public function editPassword(Request $request, UserPasswordHasherInterface $passwordEncoder, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $changePasswordForm = $this->createForm(PwType::class);
        $changePasswordForm->handleRequest($request);

        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            $user->setPassword(
                $passwordEncoder->hashPassword(
                    $user,
                    $changePasswordForm->get('password')->getData()
                )
            );
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
        }

    return $this->render('home/editpassword.html.twig', [
    'form' => $changePasswordForm->createView(),
    ]);
    return $this->redirectToRoute('user_profile');

    }
}
