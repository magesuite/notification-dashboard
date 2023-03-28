<?php
$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
$userRepository = $objectManager->create(\MageSuite\NotificationDashboard\Model\UserRepository::class);
$collectorRepository = $objectManager->create(\MageSuite\NotificationDashboard\Model\CollectorRepository::class);

$users = $userRepository->getList();

foreach ($users->getItems() as $user) {
    $userRepository->delete($user);
}

$collectorRepository->delete($collectorRepository->get('Test Collector'));
