<?php
namespace LevelShoes\Shopfinder\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for shop search results.
 * @api
 */
interface ShopSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get shops list.
     *
     * @return \LevelShoes\Shopfinder\Api\Data\ShopInterface[]
     */
    public function getItems();

    /**
     * Set shops list.
     *
     * @param \LevelShoes\Shopfinder\Api\Data\ShopInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
