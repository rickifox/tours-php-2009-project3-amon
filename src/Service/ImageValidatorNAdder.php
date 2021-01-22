<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Article;
use App\Repository\ImageRepository;

class ImageValidatorNAdder
{
    public function addImageIf(string $savedImageId, Article $article, ImageRepository $imageRepository): Article
    {
        $savedImage = $imageRepository->find($savedImageId);
        if (!empty($savedImage)) {
            $article->addImage($savedImage);
        }
        return $article;
    }
}
