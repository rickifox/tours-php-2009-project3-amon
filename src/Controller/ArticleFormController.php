<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Image;
use App\Form\ArticleFormType;
use App\Form\ImageFormType;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ImageListGenerator;
use App\Service\ImageValidatorNAdder;

class ArticleFormController extends AbstractController
{
    /**
     * @Route("/article_form/", name="article_form")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        ImageRepository $imageRepository,
        ImageListGenerator $imageListGenerator,
        ImageValidatorNAdder $imageValidatorNAdder
    ): Response {
        $image = new Image();
        $imageForm = $this->createForm(ImageFormType::class, $image);
        $article = new Article();
        $articleForm = $this->createForm(ArticleFormType::class, $article);
        $imageIds = '';
        $images = [];
        $imageForm->handleRequest($request);
        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $imageIds = $imageForm->get('otherImages')->getData();
            $entityManager->persist($image);
            $entityManager->flush();
            $imagesAndIds = $imageListGenerator->addAndGetImagesAndIds($imageIds, $image, $imageRepository);
            $imageIds = $imagesAndIds[1];
            $images = $imagesAndIds[0];
        }

        $articleForm->handleRequest($request);
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $imageIds = $articleForm->get('otherImages')->getData();
            if (!empty($imageIds)) {
                $imagesArray = explode(', ', $imageIds);
                $articleAndImages = $imageValidatorNAdder->addImageIf($imagesArray, $article, $imageRepository);
                $images = $articleAndImages[1];
                $entityManager->persist($articleAndImages[0]);
                $entityManager->flush();
                $article = new Article();
                $articleForm = $this->createForm(ArticleFormType::class, $article);
                $imageForm = '';
                return $this->render('form/article.html.twig', [
                    "articleForm" => $articleForm->createView(),
                    "imageIds" => $imageIds,
                    "images" => $images,
                ]);
            }
        }

        return $this->render('form/article.html.twig', [
            "articleForm" => $articleForm->createView(),
            "imageIds" => $imageIds,
            "images" => $images,
        ]);
    }

    /**
     * @Route("/article_form_redirect_to_image_form/", name="article_form_redirect")
     */
    public function indexForm(
        Request $request,
        EntityManagerInterface $entityManager,
        ImageRepository $imageRepository,
        ImageListGenerator $imageListGenerator,
        ImageValidatorNAdder $imageValidatorNAdder
    ): Response {
        $image = new Image();
        $imageForm = $this->createForm(ImageFormType::class, $image);
        $article = new Article();
        $articleForm = $this->createForm(ArticleFormType::class, $article);
        $imageIds = '';
        $images = [];

        $imageForm->handleRequest($request);
        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $imageIds = $imageForm->get('otherImages')->getData();
            $entityManager->persist($image);
            $entityManager->flush();
            $imagesAndIds = $imageListGenerator->addAndGetImagesAndIds($imageIds, $image, $imageRepository);
            $imageIds = $imagesAndIds[1];
            $images = $imagesAndIds[0];
        }

        $articleForm->handleRequest($request);
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $imageIds = $articleForm->get('otherImages')->getData();
            if (!empty($imageIds)) {
                $imagesArray = explode(', ', $imageIds);
                $articleAndImages = $imageValidatorNAdder->addImageIf($imagesArray, $article, $imageRepository);
                $images = $articleAndImages[1];
                $entityManager->persist($articleAndImages[0]);
                $entityManager->flush();
                $imageIds = '';
                $images = [];
                $image = new Image();
                $imageForm = $this->createForm(ImageFormType::class, $image);
                return $this->render('form/index.html.twig', [
                    "imageForm" => $imageForm->createView(),
                    "imageIds" => $imageIds,
                    "images" => $images,
                ]);
            }
        }

        return $this->render('form/article.html.twig', [
            "articleForm" => $articleForm->createView(),
            "imageIds" => $imageIds,
            "images" => $images,
        ]);
    }
}
