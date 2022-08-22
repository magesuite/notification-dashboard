<?php
$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
$userRepository = $objectManager->create(\MageSuite\NotificationDashboard\Model\UserRepository::class);

$users = $userRepository->getList();

foreach ($users->getItems() as $user) {
    $userRepository->delete($user);
}
