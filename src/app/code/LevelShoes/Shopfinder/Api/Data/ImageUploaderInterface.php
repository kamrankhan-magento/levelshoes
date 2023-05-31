<?php
namespace LevelShoes\Shopfinder\Api\Data;

/**
 * Interface for image uploader.
 * @api
 */
interface ImageUploaderInterface
{
    /**
     * Upload image file.
     *
     * @param string $imageFile
     * @return string The uploaded image file path.
     * @throws \Magento\Framework\Exception\LocalizedException If an error occurs during the image upload.
     */
    public function uploadImageFile($imageFile);
}
