<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Attachment;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
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
        $donnees = $articleRepository->findAllArticlesIsPublish();

        $articles = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            16
        );

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/{slug}', name: 'article_show', methods: ['GET', 'POST'])]
    public function show(Article $article, Request $request): Response
    {
        $comments = $article->getComments();
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setArticle($article);
            $comment->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Commentaire ajouté');
            return $this->redirectToRoute('article_show', ['slug' => $article->getSlug()], Response::HTTP_SEE_OTHER);
        }

        if($article->getIsPublish() == "0" && !$this->isGranted('ROLE_ADMIN')){
            $response = new Response();
            $response->setStatusCode(403);
            return $response;
        } else {
            return $this->render('article/show.html.twig', [
                'form' => $form->createView(),
                'article' => $article,
                'comments' => $comments
            ]);
        }
    }

    #[Route('/{id}', name: 'article_delete_attachment', methods: ['DELETE'])]
    public function deleteAttachment(Request $request, Attachment $attachment): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$attachment->getId(), $data['_token'])){
            // On récupère le nom de l'image
            $nom = $attachment->getImage();

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
