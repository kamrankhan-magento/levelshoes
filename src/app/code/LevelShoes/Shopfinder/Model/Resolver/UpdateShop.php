<?php
namespace LevelShoes\Shopfinder\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\NoSuchEntityException;
use LevelShoes\Shopfinder\Api\ShopRepositoryInterface;

class UpdateShop implements ResolverInterface
{
    /**
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * UpdateShop constructor.
     *
     * @param ShopRepositoryInterface $shopRepository
     */
    public function __construct(ShopRepositoryInterface $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    /**
     * Resolve function for updating shop information.
     *
     * @param Field $field
     * @param mixed $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     *
     * @return array|null
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $input = $args['input'];

        try {
            $shop = $this->shopRepository->getById($input['shop_id']);

            if ($shop) {
                $shop->setName($input['name']);
                $shop->setIdentifier($input['identifier']);
                $shop->setCountry($input['country']);
                $shop->setImage($input['image']);

                $this->shopRepository->save($shop);

                return [
                    'shop_id' => $shop->getId(),
                    'name' => $shop->getName(),
                    'identifier' => $shop->getIdentifier(),
                    'country' => $shop->getCountry(),
                    'image' => $shop->getImage(),
                ];
            }
        } catch (NoSuchEntityException $e) {
            // Handle the exception gracefully
            // You can log the error, throw a GraphQL error, or return a specific error response
            return [
                'error' => 'Shop not found',
            ];
        }

        return null;
    }
}
