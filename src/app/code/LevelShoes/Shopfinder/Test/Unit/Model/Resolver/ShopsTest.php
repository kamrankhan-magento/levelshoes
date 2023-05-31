<?php
namespace LevelShoes\Shopfinder\Test\Unit\Model\Resolver;

use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use LevelShoes\Shopfinder\Model\Resolver\Shops;
use LevelShoes\Shopfinder\Api\ShopRepositoryInterface;
use LevelShoes\Shopfinder\Api\Data\ShopInterface;

class ShopsTest extends TestCase
{
    /**
     * @var Shops
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

        $this->resolver = $objectManager->getObject(Shops::class, [
            'shopRepository' => $this->shopRepositoryMock
        ]);
    }

    /**
     * Test fetching all shops
     */
    public function testFetchAllShops()
    {
        $expectedResult = [
            ['shop_id' => 1, 'name' => 'Shop 1', 'identifier' => 'shop-1'],
            ['shop_id' => 2, 'name' => 'Shop 2', 'identifier' => 'shop-2'],
            ['shop_id' => 3, 'name' => 'Shop 3', 'identifier' => 'shop-3'],
        ];

        $fieldMock = $this->getMockBuilder(\Magento\Framework\GraphQl\Config\Element\Field::class)
            ->disableOriginalConstructor()
            ->getMock();

        $contextMock = $this->getMockBuilder(ContextInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $resolveInfoMock = $this->getMockBuilder(ResolveInfo::class)
            ->disableOriginalConstructor()
            ->getMock();

        $value = null;
        $args = null;

        $shop1Mock = $this->getMockBuilder(ShopInterface::class)
            ->getMock();
        $shop1Mock->expects($this->once())
            ->method('getId')
            ->willReturn(1);
        $shop1Mock->expects($this->once())
            ->method('getName')
            ->willReturn('Shop 1');
        $shop1Mock->expects($this->once())
            ->method('getIdentifier')
            ->willReturn('shop-1');

        $shop2Mock = $this->getMockBuilder(ShopInterface::class)
            ->getMock();
        $shop2Mock->expects($this->once())
            ->method('getId')
            ->willReturn(2);
        $shop2Mock->expects($this->once())
            ->method('getName')
            ->willReturn('Shop 2');
        $shop2Mock->expects($this->once())
            ->method('getIdentifier')
            ->willReturn('shop-2');

        $shop3Mock = $this->getMockBuilder(ShopInterface::class)
            ->getMock();
        $shop3Mock->expects($this->once())
            ->method('getId')
            ->willReturn(3);
        $shop3Mock->expects($this->once())
            ->method('getName')
            ->willReturn('Shop 3');
        $shop3Mock->expects($this->once())
            ->method('getIdentifier')
            ->willReturn('shop-3');

        $this->shopRepositoryMock->expects($this->once())
            ->method('getAllShops')
            ->willReturn([$shop1Mock, $shop2Mock, $shop3Mock]);

        $result = $this->resolver->resolve($fieldMock, $contextMock, $resolveInfoMock, $value, $args);

        $this->assertEquals($expectedResult, $result);
    }
}
