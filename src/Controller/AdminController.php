<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\LogRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    private RequestStack $requestStack;
    private PaginatorInterface $paginator;

    public function __construct(RequestStack $requestStack, PaginatorInterface $paginator){
        $this->requestStack = $requestStack;
        $this->paginator = $paginator;
    }

    #[Route('/', name: 'admin_index', methods: 'GET')]
    public function index(ArticleRepository $articleRepository, LogRepository $logRepository, CategoryRepository $categoryRepository, UserRepository $userRepository): Response
    {
        $articles = $articleRepository->findAllArticles();
        $logs = $logRepository->findAllLogs();
        $categories = $categoryRepository->findAllCategory();
        $users = $userRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'articles' => $articles,
            'logs' => $logs,
            'categories' => $categories,
            'users' => $users
        ]);
    }

    #[Route('/logs', name: 'admin_logs', methods: 'GET')]
    public function adminLog(LogRepository $logRepository): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $donneesLog = $logRepository->findAllLogs();

        $logs = $this->paginator->paginate(
            $donneesLog,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('admin/logs.html.twig', [
            'logs' => $logs,
        ]);
    }

    #[Route('/articles', name: 'admin_articles', methods: 'GET')]
    public function adminArticle(ArticleRepository $articleRepository): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $donneesArticle = $articleRepository->findAllArticles();

        $articles = $this->paginator->paginate(
            $donneesArticle,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('admin/articles.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/preview/{id}', name: 'admin_article_preview', methods: 'GET')]
    public function previewArticle(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/categories', name: 'admin_categories', methods: 'GET')]
    public function adminCategory(CategoryRepository $categoryRepository): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $donneesCategory = $categoryRepository->findAllCategory();

        $categories = $this->paginator->paginate(
            $donneesCategory,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('admin/categories.html.twig', [
            'categories' => $categories,
        ]);
    }
}
