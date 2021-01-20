<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Image;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

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
    public function showArticles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('gallery/actuality.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/actualites/{id}/delete", name="actuality_delete", methods="DELETE")
     */
    public function deleteArticle(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }
        return $this->redirectToRoute('actuality');
    }

        /**
     * @Route("/design-galerie/{id}/delete", name="design-gallery_delete", methods="DELETE")
     */
    public function deleteImage(Request $request, Image $image, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $request->request->get('_token'))) {
            $entityManager->remove($image);
            $entityManager->flush();
        }
        return $this->redirectToRoute('design_gallery_category', array('categorie' => $image->getCategorie()));
    }
}
