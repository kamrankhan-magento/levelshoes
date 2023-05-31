<?php

namespace LevelShoes\Shopfinder\Ui\DataProvider\Shop;

use Magento\Ui\DataProvider\AbstractDataProvider;
use LevelShoes\Shopfinder\Model\ResourceModel\Shop\CollectionFactory;

class ListingDataProvider extends AbstractDataProvider
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $this->collection->load();
        $data = $this->collection->toArray();
        return [
            'totalRecords' => $this->collection->getSize(),
            'items' => array_values($data['items']),
        ];
    }
}
