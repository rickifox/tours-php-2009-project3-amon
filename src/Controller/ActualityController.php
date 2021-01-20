<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;

class ActualityController extends AbstractController
{
    /**
     * @Route("/actualites", name="actuality")
     */
    public function showArticles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('actuality/index.html.twig', ['articles' => $articles]);
    }

    /**
     * @return object[]
     */
    public function showCarouselArticles(ArticleRepository $articleRepository): array
    {
        $articles = $articleRepository->findby(
            ['section' => 'Actualites'],
            ['id' => 'DESC'],
            3,
            0,
        );
        return $articles;
    }
}
