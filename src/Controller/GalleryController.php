<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    /**
     * @Route("/gallerie-design-metallique", name="gallerie-design-metallique")
     */
    public function metallicDesignGallery(): Response
    {
        return $this->render('gallery/metallic_design.html.twig', [
            'controller_name' => 'MetallicDesignGalleryController',
        ]);
    }

        /**
     * @Route("/gallerie-passages-secrets", name="gallerie-passages-secrets")
     */
    public function secretPassagesGallery(): Response
    {
        return $this->render('gallery/secret_passages.html.twig', [
            'controller_name' => 'SecretPassagesGalleryController',
        ]);
    }
}
