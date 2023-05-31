<?php
namespace LevelShoes\Shopfinder\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use LevelShoes\Shopfinder\Api\ShopRepositoryInterface;

class Delete extends Action
{
    /**
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param ShopRepositoryInterface $shopRepository
     */
    public function __construct(
        Context $context,
        ShopRepositoryInterface $shopRepository
    ) {
        parent::__construct($context);
        $this->shopRepository = $shopRepository;
    }

    /**
     * Delete shop
     *
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('shop_id');

        if ($id) {
            try {
                $shop = $this->shopRepository->getById($id);
                $this->shopRepository->delete($shop);
                $this->messageManager->addSuccessMessage(__('The shop has been deleted.'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while deleting the shop.'));
            }
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/index');
        return $resultRedirect;
    }
}
