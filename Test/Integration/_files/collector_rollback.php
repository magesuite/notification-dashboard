<?php
$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
$collectorRepository = $objectManager->create(\MageSuite\NotificationDashboard\Model\CollectorRepository::class);

$collectors = $collectorRepository->getList();

foreach ($collectors->getItems() as $collector) {
    try {
        $collectorRepository->delete($collector);
    } catch (\Exception $e) {
        // Already removed
    }
}
