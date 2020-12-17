<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Image;

class GalleryController extends AbstractController
{
    /**
     * @Route("/gallerie-design-metallique/", name="gallery_metallicDesign")
     */
    public function metallicDesignGallery(): Response
    {
        $images = $this->getDoctrine()
        ->getRepository(Image::class)
        ->findAll();
        return $this->render('gallery/metallicDesign.html.twig', ['images' => $images]);
    }

    /**
     * @Route("/gallerie-passages-secrets", name="gallerie-passages-secrets")
     */
    public function secretPassagesGallery(): Response
    {
        return $this->render('gallery/secret_passages.html.twig');
    }
}
