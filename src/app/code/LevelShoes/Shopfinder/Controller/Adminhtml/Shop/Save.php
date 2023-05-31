<?php
namespace LevelShoes\Shopfinder\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use LevelShoes\Shopfinder\Model\ShopFactory;

class Save extends Action
{
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var ShopFactory
     */
    private $shopFactory;

    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        ShopFactory $shopFactory
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->shopFactory = $shopFactory;
    }

    public function execute()
    {
        $postData = $this->getRequest()->getPostValue();
        if (!$postData) {
            $this->_redirect('*/*/index');
            return;
        }

        try {
            $shopData = $this->prepareShopData($postData);
            $shopId = isset($postData['shop_id']) ? (int)$postData['shop_id'] : null;
            $shop = $this->shopFactory->create();

            if ($shopId) {
                $shop->load($shopId);
                if (!$shop->getId()) {
                    throw new \Magento\Framework\Exception\LocalizedException(__('The shop no longer exists.'));
                }
            }

            $shop->setData($shopData);
            $shop->save();

            $this->messageManager->addSuccessMessage(__('The shop has been saved.'));
            $this->dataPersistor->clear('levelshoes_shopfinder_shop');

            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', ['shop_id' => $shop->getId(), '_current' => true]);
                return;
            }

            $this->_redirect('*/*/index');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('An error occurred while saving the shop: %1', $e->getMessage()));
            $this->dataPersistor->set('levelshoes_shopfinder_shop', $postData);

            $this->_redirect('*/*/edit', ['shop_id' => $shopId]);
            return;
        }
    }

    private function prepareShopData($postData)
    {
        $shopData = [
            'name' => $postData['name'],
            'identifier' => $postData['identifier'],
            'country' => $postData['country'],
        ];

        if (!empty($postData['image'][0]['name'])) {
            $shopData['image'] = $postData['image'][0]['name'];
        }

        return $shopData;
    }
}
