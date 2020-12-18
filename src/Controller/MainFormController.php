<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\MainFormType;
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
        $form = $this->createForm(MainFormType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($image);
            $entityManager->flush();
            return $this->redirectToRoute('form');
        }
        return $this->render('form/index.html.twig', [
            "form" => $form->createView(),
        ]);
    }
}
