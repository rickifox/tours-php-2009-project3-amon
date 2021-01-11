<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Image;
use App\Repository\ImageRepository;

class GalleryController extends AbstractController
{
    /**
     * @Route("/gallerie-design-metallique/", name="gallery_metallicDesign")
     */
    public function showImages(ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findAll();
        return $this->render('gallery/gallery.html.twig', ['images' => $images]);
    }

    /**
     * @Route("/gallerie-design-metallique/{categorie}", name="gallery_metallicDesign_category")
     */
    public function showImagesByCategorie(string $categorie, ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findBy([
            'categorie' => $categorie
        ]);
        return $this->render('gallery/gallery.html.twig', ['images' => $images]);
    }

    /**
     * @Route("/gallerie-passages-secrets", name="gallerie-passages-secrets")
     */
    public function secretPassagesGallery(): Response
    {
        return $this->render('gallery/secret_passages.html.twig');
    }
}
