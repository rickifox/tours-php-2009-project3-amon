<?php

namespace App\Service;

use App\Entity\Image;
use App\Repository\ImageRepository;

class ImageListGenerator
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
}
