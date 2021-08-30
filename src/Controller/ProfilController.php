<?php

namespace App\Controller;

use App\Form\UserInfoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil')]
class ProfilController extends AbstractController
{
    #[Route('/mon-profil', name: 'profil_index')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');
    }

    #[Route('/mon-profil/editer', name: 'profil_edit')]
    public function edit(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $formUpdateUser = $this->createForm(UserInfoType::class, $user);
        $formUpdateUser->handleRequest($request);

        if ($formUpdateUser->isSubmitted() && $formUpdateUser->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre profil à été modifié !');
            return $this->redirectToRoute('profil_index');
        }

        return $this->render('profil/edit.html.twig', array(
            'formUpdateUser' => $formUpdateUser->createView(),
        ));
    }


    /**
     * @return Response
     */
    #[Route('/mon-profil/supprimer', name: 'profil_remove')]
    public function remove(): Response
    {
        $user = $this->getUser();

        if ($user) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();

            $session = new Session();
            $session->invalidate();

            return $this->redirectToRoute('app_logout');
        }

        return $this->redirectToRoute("app_login");
    }
}
