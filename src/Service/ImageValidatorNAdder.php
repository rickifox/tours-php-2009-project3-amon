<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Article;
use App\Repository\ImageRepository;

class ImageValidatorNAdder
{
    /**
     * @return mixed[]
     * @param string[] $imagesArray
     */
    public function addImageIf(array $imagesArray, Article $article, ImageRepository $imageRepository): array
    {
        $images = [];
        $articleAndImages = [];
        foreach ($imagesArray as $savedImageId) {
            $savedImage = $imageRepository->find($savedImageId);
            if (!empty($savedImage)) {
                $images[] = $savedImage;
                $article->addImage($savedImage);
                $articleAndImages[0] = $article;
            }
        }
        $articleAndImages[1] = $images;
        return $articleAndImages;
    }
}
