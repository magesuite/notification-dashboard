<?php

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
$collectorRepository = $objectManager->create(\MageSuite\NotificationDashboard\Model\CollectorRepository::class);

$collector = $objectManager->create(\MageSuite\NotificationDashboard\Model\Data\Collector::class);
$collector->isObjectNew(true);
$collector
    ->setIsEnabled(true)
    ->setName('Test Collector')
    ->setType('test_item')
    ->setIsStatic(false)
    ->setCronExpression('30 */4 * * *')
    ->setVisibleOnDashboard(false)
    ->setSeverity(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_CRITICAL);

$collectorRepository->save($collector);

$collector = $objectManager->create(\MageSuite\NotificationDashboard\Model\Data\Collector::class);
$collector->isObjectNew(true);
$collector
    ->setIsEnabled(true)
    ->setName('Static Collector')
    ->setType('test_item')
    ->setIsStatic(true)
    ->setCronExpression('0 * * * *')
    ->setVisibleOnDashboard(false)
    ->setSeverity(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_NOTICE);

$collectorRepository->save($collector);
