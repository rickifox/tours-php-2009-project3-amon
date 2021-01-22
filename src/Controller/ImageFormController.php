<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageFormType;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\IdsListGenerator;

class ImageFormController extends AbstractController
{
    /**
     * @Route("/form/", name="form")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        ImageRepository $imageRepository,
        IdsListGenerator $idsListGenerator
    ): Response {
        $image = new Image();
        $imageForm = $this->createForm(ImageFormType::class, $image);

        $imageForm->handleRequest($request);
        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $imageIds = $imageForm->get('otherImages')->getData();
            $entityManager->persist($image);
            $entityManager->flush();
            $imageIds = $idsListGenerator->setImageIdsList($imageIds, $image);
            $imageIdsArr = explode(', ', $imageIds);
            foreach ($imageIdsArr as $imageId) {
                $images[] = $imageRepository->find($imageId);
            }
            $image = new Image();
            $imageForm = $this->createForm(ImageFormType::class, $image);
            return $this->render('form/index.html.twig', [
                "imageForm" => $imageForm->createView(),
                "imageIds" => $imageIds,
                "images" => $images,
            ]);
        }

        $imageIds = '';
        $images = [];
        return $this->render('form/index.html.twig', [
            "imageForm" => $imageForm->createView(),
            "imageIds" => $imageIds,
            "images" => $images,
        ]);
    }
}
