<?php

namespace LevelShoes\Shopfinder\Test\Unit\Controller\Adminhtml\Shop;

use PHPUnit\Framework\TestCase;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Controller\ResultFactory;
use LevelShoes\Shopfinder\Api\ShopRepositoryInterface;
use LevelShoes\Shopfinder\Controller\Adminhtml\Shop\Delete;
use LevelShoes\Shopfinder\Api\Data\ShopInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Magento\Backend\App\Action\Context;

class DeleteTest extends TestCase
{
    /**
     * @var Delete
     */
    protected $deleteController;

    /**
     * @var RequestInterface|MockObject
     */
    protected $requestMock;

    /**
     * @var ManagerInterface|MockObject
     */
    protected $messageManagerMock;

    /**
     * @var ResultFactory|MockObject
     */
    protected $resultFactoryMock;

    /**
     * @var ShopRepositoryInterface|MockObject
     */
    protected $shopRepositoryMock;

    protected function setUp(): void
    {
        $this->requestMock = $this->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->messageManagerMock = $this->getMockBuilder(ManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultFactoryMock = $this->getMockBuilder(ResultFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shopRepositoryMock = $this->getMockBuilder(ShopRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();
        $context->method('getRequest')->willReturn($this->requestMock);
        $context->method('getMessageManager')->willReturn($this->messageManagerMock);
        $context->method('getResultFactory')->willReturn($this->resultFactoryMock);

        $this->deleteController = new Delete(
            $context,
            $this->shopRepositoryMock
        );
    }

    public function testExecute()
    {
        $id = 1;
        $this->requestMock->method('getParam')
            ->with('shop_id')
            ->willReturn($id);

        $shopMock = $this->getMockBuilder(ShopInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shopRepositoryMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->willReturn($shopMock);

        $this->shopRepositoryMock->expects($this->once())
            ->method('delete')
            ->with($shopMock);

        $this->messageManagerMock->expects($this->once())
            ->method('addSuccessMessage')
            ->with(__('The shop has been deleted.'));

        $resultRedirectMock = $this->getMockBuilder(\Magento\Framework\Controller\Result\Redirect::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultFactoryMock->method('create')
            ->with(ResultFactory::TYPE_REDIRECT)
            ->willReturn($resultRedirectMock);

        $resultRedirectMock->method('setPath')
            ->with('*/*/index')
            ->willReturnSelf();

        $this->assertEquals($resultRedirectMock, $this->deleteController->execute());
    }
}
