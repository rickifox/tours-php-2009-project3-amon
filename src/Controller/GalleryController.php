<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Image;
use App\Repository\ArticleRepository;
use App\Repository\ImageRepository;
use Symfony\Component\BrowserKit\Response as BrowserKitResponse;

class GalleryController extends AbstractController
{
    /**
     * @Route("/design-galerie/", name="design_gallery")
     */
    public function showImages(ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findAll();
        return $this->render('gallery/design.html.twig', ['images' => $images]);
    }

    /**
     * @Route("/design-galerie/{categorie}", name="design_gallery_category")
     */
    public function showImagesByCategorie(string $categorie, ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findBy([
            'categorie' => $categorie
        ]);
        return $this->render('gallery/design.html.twig', ['images' => $images]);
    }

    /**
     * @Route("/passage-galerie", name="passage_gallery")
     */
    public function secretPassagesGallery(): Response
    {
        return $this->render('gallery/passages.html.twig');
    }

    /**
     * @Route("/actualites", name="actuality")
     */
    public function showArticles(ArticleRepository $articleRepository, ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findAll();
        $articles = $articleRepository->findAll();
        return $this->render('gallery/actuality.html.twig', ['articles' => $articles, 'images' => $images]);
    }
}
