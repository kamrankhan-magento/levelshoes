<?php
namespace LevelShoes\Shopfinder\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\MediaStorage\Model\File\Validator\NotProtectedExtension;
use Magento\Store\Model\StoreManagerInterface;

class ImageUploader
{
    protected $fileSystem;
    protected $storeManager;
    protected $uploaderFactory;
    protected $notProtectedExtensionValidator;

    public function __construct(
        Filesystem $fileSystem,
        StoreManagerInterface $storeManager,
        UploaderFactory $uploaderFactory,
        NotProtectedExtension $notProtectedExtensionValidator
    ) {
        $this->fileSystem = $fileSystem;
        $this->storeManager = $storeManager;
        $this->uploaderFactory = $uploaderFactory;
        $this->notProtectedExtensionValidator = $notProtectedExtensionValidator;
    }

    public function uploadImageFile($imageFile)
    {
        try {
            $uploader = $this->uploaderFactory->create(['fileId' => $imageFile]);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);

            $mediaDirectory = $this->fileSystem->getDirectoryWrite(DirectoryList::MEDIA);
            $destinationPath = $mediaDirectory->getAbsolutePath('shopfinder');
            $result = $uploader->save($destinationPath);

            return $result['file'];
        } catch (\Exception $e) {
            throw new LocalizedException(__('Error occurred while uploading the image. Please try again later.'));
        }
    }

    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
}
