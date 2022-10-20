<?php

namespace MageSuite\NotificationDashboard\Test\Integration\Model\Command\Notification\Collector;

/**
 * @magentoAppArea frontend
 * @magentoAppIsolation enabled
 * @magentoDbIsolation enabled
 */
class GetOrdersWithNotUpdatedStatusTest extends \PHPUnit\Framework\TestCase
{
    const ORDER_INCREMENT_ID = 100000001;

    protected ?\Magento\TestFramework\ObjectManager $objectManager;

    protected ?\MageSuite\NotificationDashboard\Model\Command\Notification\Collector\GetOrdersWithNotUpdatedStatus $getOrdersWithNotUpdatedStatus;

    protected ?\MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;

    protected ?\MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface $notificationRepository;

    protected ?\Magento\Sales\Model\Order\Config $orderConfig;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->getOrdersWithNotUpdatedStatus = $this->objectManager->get(\MageSuite\NotificationDashboard\Model\Command\Notification\Collector\GetOrdersWithNotUpdatedStatus::class);
        $this->collectorRepository = $this->objectManager->get(\MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface::class);
        $this->notificationRepository = $this->objectManager->get(\MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface::class);
        $this->orderConfig = $this->objectManager->get(\Magento\Sales\Model\Order\Config::class);
    }

    /**
     * @magentoDataFixture MageSuite_NotificationDashboard::Test/Integration/_files/collector.php
     * @magentoDataFixture Magento/Sales/_files/order_list.php
     */
    public function testItAddsNotificationCorrectly()
    {
        $collectors = $this->collectorRepository->getList()->getItems();
        $collector = array_shift($collectors);

        $configurationFormat = '{"time_delay":"%s","time_period":"%s","status":"%s"}';

        $collector->setSeverity(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_MAJOR);
        $collector->setConfiguration(sprintf($configurationFormat, 10, 20, \Magento\Sales\Model\Order::STATE_PROCESSING));

        $this->getOrdersWithNotUpdatedStatus->setCollector($collector);
        $this->getOrdersWithNotUpdatedStatus->setConfiguration($collector);

        $this->getOrdersWithNotUpdatedStatus->execute();

        $notifications = $this->notificationRepository->getList()->getItems();
        $this->assertCount(0, $notifications);

        $collector->setConfiguration(sprintf($configurationFormat, 0, 20, \Magento\Sales\Model\Order::STATE_PROCESSING));
        $this->getOrdersWithNotUpdatedStatus->setCollector($collector);
        $this->getOrdersWithNotUpdatedStatus->setConfiguration($collector);

        $this->getOrdersWithNotUpdatedStatus->execute();

        $notifications = $this->notificationRepository->getList()->getItems();
        $this->assertCount(3, $notifications);

        $notification = array_shift($notifications);

        $this->assertEquals($collector->getId(), $notification->getCollectorId());
        $this->assertEquals('Order with not updated status', $notification->getTitle());
        $this->assertStringContainsString(
            sprintf(
                'Order #%s has still %s status and it was created',
                self::ORDER_INCREMENT_ID,
                $this->orderConfig->getStatusLabel(\Magento\Sales\Model\Order::STATE_PROCESSING)
            ),
            $notification->getMessage()
        );
        $this->assertEquals(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_MAJOR, $notification->getSeverity());
    }
}
