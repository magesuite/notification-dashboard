<?php
$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
$collectorRepository = $objectManager->create(\MageSuite\NotificationDashboard\Model\CollectorRepository::class);

$collectorRepository->delete($collectorRepository->get('Test Collector'));
$collectorRepository->delete($collectorRepository->get('Static Collector'));
