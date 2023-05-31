<?php
namespace LevelShoes\Shopfinder\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use LevelShoes\Shopfinder\Api\ShopRepositoryInterface;
use LevelShoes\Shopfinder\Api\Data\ShopInterface;

class Shop implements ResolverInterface
{
    /**
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * LevelShoesShop constructor.
     *
     * @param ShopRepositoryInterface $shopRepository
     */
    public function __construct(ShopRepositoryInterface $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    /**
     * Resolve function for fetching a single shop based on identifier.
     *
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     *
     * @return ShopInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $identifier = $args['identifier'];
        return $this->shopRepository->getByIdentifier($identifier);
    }
}
