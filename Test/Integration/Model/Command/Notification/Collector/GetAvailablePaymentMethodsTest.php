<?php

namespace MageSuite\NotificationDashboard\Test\Integration\Model\Command\Notification\Collector;

/**
 * @magentoAppArea frontend
 * @magentoAppIsolation enabled
 * @magentoDbIsolation enabled
 */
class GetAvailablePaymentMethodsTest extends \PHPUnit\Framework\TestCase
{
    const SPECIFIC_STORE_ID = 1;
    const SPECIFIC_STORE_NAME = 'Default Store View';

    protected ?\Magento\TestFramework\ObjectManager $objectManager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Magento\Payment\Api\PaymentMethodListInterface
     */
    protected $paymentMethodListMock;

    protected ?\MageSuite\NotificationDashboard\Model\Command\Notification\Collector\GetAvailablePaymentMethods $getAvailablePaymentMethods;

    protected ?\MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;

    protected ?\MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface $notificationRepository;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->paymentMethodListMock = $this->getMockBuilder(\Magento\Payment\Api\PaymentMethodListInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->getAvailablePaymentMethods = $this->objectManager->create(
            \MageSuite\NotificationDashboard\Model\Command\Notification\Collector\GetAvailablePaymentMethods::class,
            [
                'paymentMethodList' => $this->paymentMethodListMock,
            ]
        );

        $this->collectorRepository = $this->objectManager->get(\MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface::class);
        $this->notificationRepository = $this->objectManager->get(\MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface::class);
    }

    public function testItDoesNotAddNotificationsForActiveMethods()
    {
        $this->paymentMethodListMock->method('getActiveList')->with(self::SPECIFIC_STORE_ID)->willReturn(['payment_method']);
        $this->getAvailablePaymentMethods->execute();

        $notifications = $this->notificationRepository->getList()->getItems();
        $this->assertCount(0, $notifications);
    }

    /**
     * @magentoDataFixture MageSuite_NotificationDashboard::Test/Integration/_files/collector.php
     */
    public function testItAddsNotificationForNoActiveMethods()
    {
        $collectors = $this->collectorRepository->getList()->getItems();
        $collector = array_shift($collectors);

        $collector->setSeverity(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_MAJOR);
        $collector->setConfiguration('{}');

        $this->getAvailablePaymentMethods->setCollector($collector);
        $this->getAvailablePaymentMethods->setConfiguration($collector);

        $this->paymentMethodListMock->method('getActiveList')->with(self::SPECIFIC_STORE_ID)->willReturn([]);
        $this->getAvailablePaymentMethods->execute();

        $notifications = $this->notificationRepository->getList()->getItems();
        $this->assertCount(1, $notifications);

        $notification = array_shift($notifications);

        $this->assertEquals($collector->getId(), $notification->getCollectorId());
        $this->assertEquals('Missing payment methods', $notification->getTitle());
        $this->assertStringContainsString(sprintf('Missing payment methods in %s store', self::SPECIFIC_STORE_NAME), $notification->getMessage());
        $this->assertEquals(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_MAJOR, $notification->getSeverity());
    }
}
