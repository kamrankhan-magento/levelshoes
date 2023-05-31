<?php
namespace LevelShoes\Shopfinder\Model;

use LevelShoes\Shopfinder\Api\Data\ShopInterface;
use LevelShoes\Shopfinder\Api\Data\ShopSearchResultsInterfaceFactory;
use LevelShoes\Shopfinder\Api\ShopRepositoryInterface;
use LevelShoes\Shopfinder\Model\ResourceModel\Shop as ShopResource;
use LevelShoes\Shopfinder\Model\ResourceModel\Shop\CollectionFactory as ShopCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class ShopRepository implements ShopRepositoryInterface
{
    /**
     * @var ShopFactory
     */
    protected $shopFactory;

    /**
     * @var ShopResource
     */
    protected $shopResource;

    /**
     * @var ShopCollectionFactory
     */
    protected $shopCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ShopSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * ShopRepository constructor.
     *
     * @param ShopFactory $shopFactory
     * @param ShopResource $shopResource
     * @param ShopCollectionFactory $shopCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param ShopSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        ShopFactory $shopFactory,
        ShopResource $shopResource,
        ShopCollectionFactory $shopCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        ShopSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->shopFactory = $shopFactory;
        $this->shopResource = $shopResource;
        $this->shopCollectionFactory = $shopCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($shopId)
    {
        $shop = $this->shopFactory->create();
        $this->shopResource->load($shop, $shopId);
        if (!$shop->getId()) {
            throw new NoSuchEntityException(__('Shop with specified ID "%1" does not exist.', $shopId));
        }
        return $shop;
    }

    /**
     * {@inheritdoc}
     */
    public function getByIdentifier($identifier)
    {
        $shop = $this->shopFactory->create();
        $this->shopResource->load($shop, $identifier, ShopInterface::IDENTIFIER);
        if (!$shop->getId()) {
            throw new NoSuchEntityException(__('Shop with specified identifier "%1" does not exist.', $identifier));
        }
        return $shop;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->shopCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ShopInterface $shop)
    {
        try {
            $this->shopResource->save($shop);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Unable to save the shop.'), $e);
        }
        return $shop;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ShopInterface $shop)
    {
        try {
            $this->shopResource->delete($shop);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Unable to delete the shop.'), $e);
        }
        return true;
    }

    public function getAllShops()
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($this->shopResource->getAllShops());
        $searchResults->setTotalCount(count($searchResults->getItems()));
        return $searchResults;
    }

    public function updateShop(array $data): ShopInterface
    {
        $shop = $this->shopFactory->create();
        if (isset($data['shop_id'])) {
            $this->shopResource->load($shop, $data['shop_id']);
            if (!$shop->getId()) {
                throw new NoSuchEntityException(__('The shop with the specified ID does not exist.'));
            }
        }
        $shop->setData($data);
        try {
            $this->shopResource->save($shop);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Could not save the shop.'), $e);
        }
        return $shop;
    }
}
