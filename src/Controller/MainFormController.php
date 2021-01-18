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

class MainFormController extends AbstractController
{
    /**
     * @Route("/form/", name="form")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        ImageRepository $imageRepository
    ): Response {
        $image = new Image();
        $imageForm = $this->createForm(ImageFormType::class, $image);
        $article = new Article();
        $articleForm = $this->createForm(ArticleFormType::class, $article);

        $imageForm->handleRequest($request);
        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $images = $imageForm->get('otherImages')->getData();
            $entityManager->persist($image);
            $entityManager->flush();
            if (!empty($images)) {
                $images = $images . ', ' . $image->getId();
            } else {
                $images = $image->getId();
            }
            return $this->render('form/index.html.twig', [
                "imageForm" => $imageForm->createView(),
                "articleForm" => $articleForm->createView(),
                "images" => $images,
            ]);
        }

        $articleForm->handleRequest($request);
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $images = $articleForm->get('otherImages')->getData();
            if (!empty($images)) {
                $imagesArray = explode(', ', $images);
                foreach ($imagesArray as $savedImageId) {
                    $savedImage = $imageRepository->find($savedImageId);
                    if (!empty($savedImage)) {
                        $article->addImage($savedImage);
                    }
                }
                $entityManager->persist($article);
                $entityManager->flush();
                return $this->redirectToRoute('form');
            }
        }

        $images = '';
        return $this->render('form/index.html.twig', [
            "imageForm" => $imageForm->createView(),
            "articleForm" => $articleForm->createView(),
            "images" => $images,
        ]);
    }
}
