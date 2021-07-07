<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\ActualityController;
use App\Repository\ArticleRepository;

class DesignController extends AbstractController
{
    /**
     * @Route("/design", name="design_index")
     */
    public function index(ActualityController $actualityController, ArticleRepository $articleRepository): Response
    {
        $news = $actualityController->showCarouselArticles($articleRepository);
        return $this->render('design/index.html.twig', ['news' => $news]);
    }
}
