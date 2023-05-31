<?php

namespace LevelShoes\Shopfinder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use LevelShoes\Shopfinder\Api\Data\ShopInterface;

class Shop extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('levelshoes_shopfinder_shop', ShopInterface::ENTITY_ID);
    }

    public function getAllShops(): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from($this->getMainTable());
        return $connection->fetchAll($select);
    }
}
