<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Attachment;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Service\AttachmentServiceInterface;
use DateTimeImmutable;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'article_index', methods: ['GET'])]
    public function index(Request $request, ArticleRepository $articleRepository, PaginatorInterface $paginator): Response
    {
        $donnees = $articleRepository->findAllArticles();

        $articles = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            16
        );

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/new', name: 'article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AttachmentServiceInterface $attachmentService): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // On récupère les images transmises
            $attachments = $form->get('attachment')->getData();

            // On boucle sur les images
            foreach($attachments as $attachment){
                $fileUpload = $attachmentService->uploadAttachment($attachment);
                $article->addAttachment($fileUpload);
            }

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
    public function edit(Request $request, Article $article, AttachmentServiceInterface $attachmentService): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $attachments = $form->get('attachment')->getData();

            // On boucle sur les images
            foreach($attachments as $attachment){
                $fileUpload = $attachmentService->uploadAttachment($attachment);
                $article->addAttachment($fileUpload);
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
