<?php

namespace MageSuite\NotificationDashboard\Test\Integration\Model\Command\Notification;

class AddNotificationTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\Framework\ObjectManagerInterface $objectManager;

    protected ?\MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository;

    protected ?\MageSuite\NotificationDashboard\Model\NotificationRepository $notificationRepository;

    protected ?\MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification;

    protected ?\Magento\AdminNotification\Model\ResourceModel\Inbox\Collection $inboxCollection;

    protected function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

        $this->collectorRepository = $this->objectManager->get(\MageSuite\NotificationDashboard\Model\CollectorRepository::class);
        $this->notificationRepository = $this->objectManager->get(\MageSuite\NotificationDashboard\Model\NotificationRepository::class);
        $this->addNotification = $this->objectManager->get(\MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification::class);
        $this->inboxCollection = $this->objectManager->get(\Magento\AdminNotification\Model\ResourceModel\Inbox\Collection::class);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoDataFixture MageSuite_NotificationDashboard::Test/Integration/_files/collector_with_user.php
     */
    public function testItAddsNotificationCorrectly()
    {
        $message = 'Dummy message';
        $title = 'Item name';
        $collector = $this->collectorRepository->get('Test Collector');

        $notifications = $this->notificationRepository->getList();
        $this->assertCount(0, $notifications->getItems());

        $this->addNotification->execute($message, $collector->getId(), $collector->getSeverity(), $title);

        $notifications = $this->notificationRepository->getList();
        $items = $notifications->getItems();
        $this->assertCount(1, $items);

        $item = array_shift($items);

        $this->assertEquals($message, $item->getMessage());
        $this->assertEquals($title, $item->getTitle());
        $this->assertEquals($collector->getId(), $item->getCollectorId());
        $this->assertEquals(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_CRITICAL, $item->getSeverity());

        $notificationWasAddedToInbox = false;

        foreach ($this->inboxCollection->getItems() as $item) {
            if ($item->getTitle() != $title || $item->getDescription() != $message) {
                continue;
            }

            $notificationWasAddedToInbox = true;
        }

        $this->assertTrue($notificationWasAddedToInbox);
    }
}
