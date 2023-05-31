<?php
namespace LevelShoes\Shopfinder\Test\Unit\Model\Resolver;

use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use LevelShoes\Shopfinder\Model\Resolver\Shop;
use LevelShoes\Shopfinder\Api\ShopRepositoryInterface;
use LevelShoes\Shopfinder\Api\Data\ShopInterface;

class ShopTest extends TestCase
{
    /**
     * @var Shop
     */
    protected $resolver;

    /**
     * @var ShopRepositoryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $shopRepositoryMock;

    protected function setUp(): void
    {
        $objectManager = new ObjectManager($this);

        $this->shopRepositoryMock = $this->getMockBuilder(ShopRepositoryInterface::class)
            ->getMock();

        $this->resolver = $objectManager->getObject(Shop::class, [
            'shopRepository' => $this->shopRepositoryMock
        ]);
    }

    /**
     * Test fetching a single shop by identifier (success)
     */
    public function testFetchShopByIdentifierSuccess()
    {
        $identifier = 'shop2';
        $expectedShop = $this->createMock(ShopInterface::class);

        $fieldMock = $this->getMockBuilder(\Magento\Framework\GraphQl\Config\Element\Field::class)
            ->disableOriginalConstructor()
            ->getMock();

        $contextMock = $this->getMockBuilder(ContextInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $resolveInfoMock = $this->getMockBuilder(ResolveInfo::class)
            ->disableOriginalConstructor()
            ->getMock();

        $args = [
            'identifier' => $identifier
        ];

        $this->shopRepositoryMock->expects($this->once())
            ->method('getByIdentifier')
            ->with($identifier)
            ->willReturn($expectedShop);

        $result = $this->resolver->resolve($fieldMock, $contextMock, $resolveInfoMock, null, $args);

        $this->assertInstanceOf(ShopInterface::class, $result);
        $this->assertEquals($expectedShop, $result);
    }
}
