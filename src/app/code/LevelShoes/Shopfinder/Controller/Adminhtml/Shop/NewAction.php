<?php
namespace LevelShoes\Shopfinder\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultInterface;

class NewAction extends Action
{
    /**
     * Add new shop
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('levelshoes_shopfinder/shop/edit');
        return $resultRedirect;
    }
}
