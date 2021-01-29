<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Article;
use App\Repository\ImageRepository;

class ImagesHandler
{
    /**
     * @return mixed[]
     */
    public function addAndGetImagesAndIds(?string $imageIds, Image $image, ImageRepository $imageRepository): array
    {
        $imagesAndIds = [];
        $images = [];
        if (!empty($imageIds)) {
            $imageIds = $imageIds . ', ' . $image->getId();
        } else {
            $imageIds = strval($image->getId());
        }
        $imagesAndIds[1] = $imageIds;
        $imageIdsArr = explode(', ', $imageIds);
        foreach ($imageIdsArr as $imageId) {
            $images[] = $imageRepository->find($imageId);
        }
        $imagesAndIds[0] = $images;
        return $imagesAndIds;
    }

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
