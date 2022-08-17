<?php

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
$userRepository = $objectManager->create(\MageSuite\NotificationDashboard\Model\UserRepository::class);
$collectorRepository = $objectManager->create(\MageSuite\NotificationDashboard\Model\CollectorRepository::class);
$collectorUserRepository = $objectManager->create(\MageSuite\NotificationDashboard\Model\CollectorUserRepository::class);

$user = $objectManager->create(\MageSuite\NotificationDashboard\Model\Data\User::class);
$user->isObjectNew(true);
$user
    ->setName('Test User')
    ->setEmail('john@example.com')
    ->setIsStatic(false);

$user = $userRepository->save($user);

$collector = $objectManager->create(\MageSuite\NotificationDashboard\Model\Data\Collector::class);
$collector->isObjectNew(true);
$collector
    ->setIsEnabled(true)
    ->setName('Test Collector')
    ->setType('test_item')
    ->setIsStatic(false)
    ->setCronExpression('30 */4 * * *')
    ->setVisibleOnDashboard(false)
    ->setAddAdminNotification(true)
    ->setSeverity(\MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_CRITICAL);

$collector = $collectorRepository->save($collector);

$collectorUser = $objectManager->create(\MageSuite\NotificationDashboard\Model\Data\CollectorUser::class);
$collectorUser->isObjectNew(true);
$collectorUser
    ->setCollectorId($collector->getId())
    ->setUserId($user->getId())
    ->setSendEmail(false);

$collectorUserRepository->save($collectorUser);
