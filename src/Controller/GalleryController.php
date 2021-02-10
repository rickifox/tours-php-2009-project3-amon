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
use Knp\Component\Pager\PaginatorInterface;

class GalleryController extends AbstractController
{
    /**
     * @Route("/design-galerie/", name="design_gallery")
     */
    public function showImages(
        ImageRepository $imageRepository,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $data = $imageRepository->findBy(
            ['categorie' => ['aménagement extérieur', 'brise-vue et pare-soleil', 'décoration', 'escalier',
            'garde-corps', 'passages secrets', 'trappes vitrées', 'verrières']],
            ['id' => 'DESC'],
        );
        $images = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            15
        );
        return $this->render(
            'gallery/design.html.twig',
            ['images' => $images, 'categorie' => 'Toutes les catégories'],
        );
    }

    /**
     * @Route("/design-galerie/{categorie}", name="design_gallery_category")
     */
    public function showImagesByCategorie(
        Request $request,
        PaginatorInterface $paginator,
        string $categorie,
        ImageRepository $imageRepository
    ): Response {
        $data = $imageRepository->findBy(
            ['categorie' => $categorie],
            ['id' => 'DESC']
        );

        $images = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            15
        );
        if (!empty($data)) {
            return $this->render('gallery/design.html.twig', ['images' => $images, 'categorie' => $categorie]);
        } else {
            return $this->redirectToRoute('design_gallery');
        }
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
    public function passageImages(
        ImageRepository $imageRepository,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $data = $imageRepository->findBy(
            ['categorie' => ['miroirs', 'bibliothèques']]
        );

        $images = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            15
        );
        return $this->render(
            'gallery/passage.html.twig',
            ['images' => $images, 'categorie' => 'Tous les passages secrets']
        );
    }

    /**
     * @Route("/passage-galerie/{categorie}", name="passage_gallery_category")
     */
    public function passageImagesByCategorie(
        string $categorie,
        ImageRepository $imageRepository,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $data = $imageRepository->findBy(
            ['categorie' => $categorie],
            ['id' => 'DESC']
        );

        $images = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            15
        );
        if (!empty($data)) {
            return $this->render('gallery/passage.html.twig', ['images' => $images, 'categorie' => $categorie]);
        } else {
            return $this->redirectToRoute('passage_gallery');
        }
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
