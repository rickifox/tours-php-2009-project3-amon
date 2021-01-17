<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Image;
use App\Form\ArticleFormType;
use App\Form\ImageFormType;
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
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $image = new Image();
        $imageForm = $this->createForm(ImageFormType::class, $image);
        $article = new Article();
        $articleForm = $this->createForm(ArticleFormType::class, $article);

        $images = '';

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
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('form');
        }
        return $this->render('form/index.html.twig', [
            "imageForm" => $imageForm->createView(),
            "articleForm" => $articleForm->createView(),
            "images" => $images,
        ]);
    }
}
