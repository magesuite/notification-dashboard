<?php
$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
$userRepository = $objectManager->create(\MageSuite\NotificationDashboard\Model\UserRepository::class);
$collectorRepository = $objectManager->create(\MageSuite\NotificationDashboard\Model\CollectorRepository::class);

$users = $userRepository->getList();

foreach ($users->getItems() as $user) {
    try {
        $userRepository->delete($user);
    } catch (\Exception $e) {
        // Already removed
    }
}

$collectors = $collectorRepository->getList();

foreach ($collectors->getItems() as $collector) {
    try {
        $collectorRepository->delete($collector);
    } catch (\Exception $e) {
        // Already removed
    }
}
