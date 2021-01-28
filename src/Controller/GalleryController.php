<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/article/{image}", name="article_by_image_id")
     */
    public function showArticle(Image $image): Response
    {
        $articles = $image->getArticles();
        foreach ($articles as $article) {
            if ($article->getSection() === "Galerie") {
                return new JsonResponse(['data' => json_encode(
                    $article->getArray()
                )]);
            }
        }
        return new JsonResponse(['data' => json_encode($image)]);
    }

    /**
     * @Route("/design-galerie/", name="design_gallery")
     */
    public function showImages(ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findBy(
            ['categorie' => ['aménagement extérieur', 'brise-vue pare-soleil', 'décoration', 'escalier',
            'garde-corps', 'passages secrets', 'trappes vitrées', 'verrière']],
            ['id' => 'DESC'],
        );
        return $this->render(
            'gallery/design.html.twig',
            ['images' => $images, 'categorie' => 'Toutes les catégories'],
        );
    }

    /**
     * @Route("/design-galerie/{categorie}", name="design_gallery_category")
     */
    public function showImagesByCategorie(string $categorie, ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findBy(
            ['categorie' => $categorie],
            ['id' => 'DESC']
        );
            return $this->render('gallery/design.html.twig', ['images' => $images, 'categorie' => $categorie]);
    }

    /**
     * @Route("/design-galerie/{id}/delete", name="design_gallery_delete", methods="DELETE")
     */
    public function deleteImage(Request $request, Image $image, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $request->request->get('_token'))) {
            $entityManager->remove($image);
            $entityManager->flush();
        }
        return $this->redirectToRoute('design_gallery_category', array('categorie' => $image->getCategorie()));
    }

    /**
     * @Route("/passage-galerie", name="passage_gallery")
     */
    public function passageImages(ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findBy(
            ['categorie' => ['miroirs', 'bibliotheques', 'sur-mesure']]
        );
        return $this->render(
            'gallery/passage.html.twig',
            ['images' => $images, 'categorie' => 'Tous les passages secrets']
        );
    }

    /**
     * @Route("/passage-galerie/{categorie}", name="passage_gallery_category")
     */
    public function passageImagesByCategorie(string $categorie, ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findBy([
            'categorie' => $categorie
        ]);
        return $this->render('gallery/passage.html.twig', ['images' => $images, 'categorie' => $categorie]);
    }

    /**
     * @Route("/passage-galerie/{id}/delete", name="passage_gallery_delete", methods="DELETE")
     */
    public function deletePassageImage(Request $request, Image $image, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $request->request->get('_token'))) {
            $entityManager->remove($image);
            $entityManager->flush();
        }
        return $this->redirectToRoute('passage_gallery_category', array('categorie' => $image->getCategorie()));
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
}
