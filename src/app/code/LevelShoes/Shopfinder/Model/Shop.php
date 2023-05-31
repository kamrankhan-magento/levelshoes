<?php
namespace LevelShoes\Shopfinder\Model;

use LevelShoes\Shopfinder\Api\Data\ShopInterface;
use LevelShoes\Shopfinder\Helper\ImageUploader;
use Magento\Framework\Model\AbstractModel;

class Shop extends AbstractModel implements ShopInterface
{
    /**
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * Shop constructor.
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ImageUploader $imageUploader
     * @param \LevelShoes\Shopfinder\Model\ResourceModel\Shop $resource
     * @param \LevelShoes\Shopfinder\Model\ResourceModel\Shop\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ImageUploader $imageUploader,
        \LevelShoes\Shopfinder\Model\ResourceModel\Shop $resource,
        \LevelShoes\Shopfinder\Model\ResourceModel\Shop\Collection $resourceCollection,
        array $data = []
    ) {
        $this->imageUploader = $imageUploader;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(\LevelShoes\Shopfinder\Model\ResourceModel\Shop::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->getData(self::IDENTIFIER);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry()
    {
        return $this->getData(self::COUNTRY);
    }

    /**
     * {@inheritdoc}
     */
    public function setCountry($country)
    {
        return $this->setData(self::COUNTRY, $country);
    }

    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * {@inheritdoc}
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }
}
