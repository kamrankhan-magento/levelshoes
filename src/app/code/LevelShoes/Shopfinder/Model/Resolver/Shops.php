<?php
namespace LevelShoes\Shopfinder\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use LevelShoes\Shopfinder\Api\ShopRepositoryInterface;

class Shops implements ResolverInterface
{
    /**
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * ShoesShops constructor.
     *
     * @param ShopRepositoryInterface $shopRepository
     */
    public function __construct(ShopRepositoryInterface $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    /**
     * Resolve function for fetching all shops.
     *
     * @param Field $field
     * @param mixed $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     *
     * @return array
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $shopSearchResults = $this->shopRepository->getAllShops();
        return $shopSearchResults->getItems();
    }
}
