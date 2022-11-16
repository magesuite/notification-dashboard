<?php

namespace MageSuite\NotificationDashboard\Test\Integration\Model\Command\Notification\Collector;

/**
 * @magentoAppArea frontend
 * @magentoAppIsolation enabled
 * @magentoDbIsolation enabled
 */
class GetProductsWithoutImagesTest extends \PHPUnit\Framework\TestCase
{

    protected ?\Magento\TestFramework\ObjectManager $objectManager;

    protected ?\MageSuite\NotificationDashboard\Model\Command\Notification\Collector\GetProductsWithoutImages $getProductsWithoutImages;

    protected ?\MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;

    protected ?\MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface $notificationRepository;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->getProductsWithoutImages = $this->objectManager->get(\MageSuite\NotificationDashboard\Model\Command\Notification\Collector\GetProductsWithoutImages::class);
        $this->collectorRepository = $this->objectManager->get(\MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface::class);
        $this->notificationRepository = $this->objectManager->get(\MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface::class);
    }

    /**
     * @magentoDataFixture MageSuite_NotificationDashboard::Test/Integration/_files/collector.php
     * @magentoDataFixture Magento/Catalog/_files/products_list.php
     */
    public function testItAddsNotificationCorrectly()
    {
        $productsWithoutImagesSkua = [
            'simple-156',
            'simple-249',
            'wrong-simple'
        ];
        $collectors = $this->collectorRepository->getList()->getItems();
        $collector = array_shift($collectors);

        $configurationFormat = '{"type_ids":%s,"excluded_skus":"%s"}';

        $collector->setSeverity(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_MAJOR);
        $collector->setConfiguration(sprintf($configurationFormat, '["simple","bundle"]', implode(',', $productsWithoutImagesSkua)));

        $this->getProductsWithoutImages->setCollector($collector);
        $this->getProductsWithoutImages->setConfiguration($collector);

        $this->getProductsWithoutImages->execute();

        $notifications = $this->notificationRepository->getList()->getItems();
        $this->assertCount(0, $notifications);

        $collector->setConfiguration(sprintf($configurationFormat, '["simple","bundle"]', ''));
        $this->getProductsWithoutImages->setCollector($collector);
        $this->getProductsWithoutImages->setConfiguration($collector);

        $this->getProductsWithoutImages->execute();

        $notifications = $this->notificationRepository->getList()->getItems();
        $this->assertCount(3, $notifications);

        $notification = array_shift($notifications);

        $this->assertEquals($collector->getId(), $notification->getCollectorId());
        $this->assertEquals('Missing product images', $notification->getTitle());
        $this->assertEquals(sprintf('Product with sku %s (type simple) has no images', $productsWithoutImagesSkua[0]), $notification->getMessage());
        $this->assertEquals(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_MAJOR, $notification->getSeverity());
    }
}
