<?php

namespace App\Service;

use App\Entity\Image;

class IdsListGenerator
{
    public function setImageIdsList(?string $imageIds, Image $image): string
    {
        if (!empty($imageIds)) {
            $imageIds = $imageIds . ', ' . $image->getId();
        } else {
            $imageIds = strval($image->getId());
        }
        return $imageIds;
    }
}
