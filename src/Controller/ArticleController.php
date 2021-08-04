<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Attachment;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findLastArticles(),
        ]);
    }

    #[Route('/new', name: 'article_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // On récupère les images transmises
            $attachments = $form->get('attachment')->getData();

            // On boucle sur les images
            foreach($attachments as $attachment){

                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$attachment->guessExtension();

                // On copie le fichier dans le dossier uploads
                $attachment->move(
                    $this->getParameter('upload_directory'),
                    $fichier
                );

                // On crée l'image dans la base de données
                $attachment = new Attachment();
                $attachment->setName($fichier);
                $article->addAttachment($attachment);
            }

            $article->setCreatedAt(new \DateTimeImmutable());
            $article->setUpdatedAt(new \DateTimeImmutable());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Nouvel article créé');
            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $attachments = $form->get('attachment')->getData();

            // On boucle sur les images
            foreach($attachments as $attachment){

                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$attachment->guessExtension();

                // On copie le fichier dans le dossier uploads
                $attachment->move(
                    $this->getParameter('upload_directory'),
                    $fichier
                );

                // On crée l'image dans la base de données
                $attachment = new Attachment();
                $attachment->setName($fichier);
                $article->addAttachment($attachment);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Article modifié !');
            return $this->redirectToRoute('article_edit', ['id' => $article->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Article supprimé');
        return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'article_delete_attachment', methods: ['DELETE'])]
    public function deleteAttachment(Request $request, Attachment $attachment): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$attachment->getId(), $data['_token'])){
            // On récupère le nom de l'image
            $nom = $attachment->getName();

            // On supprime le fichier
            unlink($this->getParameter('upload_directory').'/'.$nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($attachment);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
