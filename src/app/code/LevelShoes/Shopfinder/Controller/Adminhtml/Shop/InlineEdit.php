<?php

namespace LevelShoes\Shopfinder\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use LevelShoes\Shopfinder\Api\ShopRepositoryInterface;

class InlineEdit extends Action
{
    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * InlineEdit constructor.
     *
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param ShopRepositoryInterface $shopRepository
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        ShopRepositoryInterface $shopRepository
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->shopRepository = $shopRepository;
    }

    /**
     * Save inline edited shop
     *
     * @return Json
     */
    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();

        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach ($postItems as $item) {
            $shopId = $item['shop_id'];
            try {
                $shop = $this->shopRepository->getById($shopId);
                $shop->setData($item);
                $this->shopRepository->save($shop);
            } catch (LocalizedException $e) {
                $messages[] = $this->getErrorWithShopId($shop, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithShopId($shop, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithShopId(
                    $shop,
                    __('Something went wrong while saving the shop.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error,
        ]);
    }

    /**
     * Add shop ID to error message
     *
     * @param \LevelShoes\Shopfinder\Api\Data\ShopInterface $shop
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithShopId($shop, $errorText)
    {
        return '[Shop ID: ' . $shop->getId() . '] ' . $errorText;
    }
}
