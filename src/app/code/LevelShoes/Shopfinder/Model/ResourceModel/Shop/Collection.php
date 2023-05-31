<?php
namespace LevelShoes\Shopfinder\Model\ResourceModel\Shop;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use LevelShoes\Shopfinder\Model\Shop;
use LevelShoes\Shopfinder\Model\ResourceModel\Shop as ShopResource;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(Shop::class, ShopResource::class);
    }
}
