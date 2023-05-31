<?php
namespace LevelShoes\Shopfinder\Api;

use LevelShoes\Shopfinder\Api\Data\ShopInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Shop repository interface.
 * @api
 */
interface ShopRepositoryInterface
{
    /**
     * Get shop by ID.
     *
     * @param int $shopId
     * @return \LevelShoes\Shopfinder\Api\Data\ShopInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If shop with the specified ID does not exist.
     */
    public function getById($shopId);

    /**
     * Get shop by identifier.
     *
     * @param string $identifier
     * @return \LevelShoes\Shopfinder\Api\Data\ShopInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If shop with the specified identifier does not exist.
     */
    public function getByIdentifier($identifier);

    /**
     * Get list of shops.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \LevelShoes\Shopfinder\Api\Data\ShopSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Save shop.
     *
     * @param \LevelShoes\Shopfinder\Api\Data\ShopInterface $shop
     * @return \LevelShoes\Shopfinder\Api\Data\ShopInterface
     * @throws \Magento\Framework\Exception\LocalizedException If the shop cannot be saved.
     */
    public function save(ShopInterface $shop);

    /**
     * Delete shop.
     *
     * @param \LevelShoes\Shopfinder\Api\Data\ShopInterface $shop
     * @return bool True on success
     * @throws \Magento\Framework\Exception\LocalizedException If the shop cannot be deleted.
     */
    public function delete(ShopInterface $shop);
}
