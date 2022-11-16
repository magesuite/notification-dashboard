<?php

namespace MageSuite\NotificationDashboard\Test\Integration\Model\Command\Notification\Collector;

/**
 * @magentoAppArea frontend
 * @magentoAppIsolation enabled
 * @magentoDbIsolation enabled
 */
class GetOrdersWithNotPaidInvoicesTest extends \PHPUnit\Framework\TestCase
{
    const ORDER_INCREMENT_ID = 100000001;

    protected ?\Magento\TestFramework\ObjectManager $objectManager;

    protected ?\MageSuite\NotificationDashboard\Model\Command\Notification\Collector\GetOrdersWithNotPaidInvoices $getOrdersWithNotPaidInvoices;

    protected ?\MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;

    protected ?\MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface $notificationRepository;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->getOrdersWithNotPaidInvoices = $this->objectManager->get(\MageSuite\NotificationDashboard\Model\Command\Notification\Collector\GetOrdersWithNotPaidInvoices::class);
        $this->collectorRepository = $this->objectManager->get(\MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface::class);
        $this->notificationRepository = $this->objectManager->get(\MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface::class);
    }

    /**
     * @magentoDataFixture MageSuite_NotificationDashboard::Test/Integration/_files/collector.php
     * @magentoDataFixture Magento/Sales/_files/invoice_list.php
     */
    public function testItAddsNotificationCorrectly()
    {
        $collectors = $this->collectorRepository->getList()->getItems();
        $collector = array_shift($collectors);

        $collector->setSeverity(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_MAJOR);
        $collector->setConfiguration('{"time_delay":"10","time_period":"10"}');

        $this->getOrdersWithNotPaidInvoices->setCollector($collector);
        $this->getOrdersWithNotPaidInvoices->setConfiguration($collector);

        $this->getOrdersWithNotPaidInvoices->execute();

        $notifications = $this->notificationRepository->getList()->getItems();
        $this->assertCount(0, $notifications);

        $collector->setConfiguration('{"time_delay":"0","time_period":"20"}');
        $this->getOrdersWithNotPaidInvoices->setCollector($collector);
        $this->getOrdersWithNotPaidInvoices->setConfiguration($collector);

        $this->getOrdersWithNotPaidInvoices->execute();

        $notifications = $this->notificationRepository->getList()->getItems();
        $this->assertCount(3, $notifications);

        $notification = array_shift($notifications);

        $this->assertEquals($collector->getId(), $notification->getCollectorId());
        $this->assertEquals('Order with open invoice', $notification->getTitle());
        $this->assertStringContainsString(sprintf('Order #%s has still open invoice and it was created', self::ORDER_INCREMENT_ID), $notification->getMessage());
        $this->assertEquals(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_MAJOR, $notification->getSeverity());
    }
}
