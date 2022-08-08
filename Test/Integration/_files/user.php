<?php

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
$userRepository = $objectManager->create(\MageSuite\NotificationDashboard\Model\UserRepository::class);

$user = $objectManager->create(\MageSuite\NotificationDashboard\Model\Data\User::class);
$user->isObjectNew(true);
$user
    ->setName('Test User')
    ->setEmail('john@example.com')
    ->setIsStatic(false);

$userRepository->save($user);

$user = $objectManager->create(\MageSuite\NotificationDashboard\Model\Data\User::class);
$user->isObjectNew(true);
$user
    ->setName('Static User')
    ->setEmail('jane@example.com')
    ->setIsStatic(true);

$userRepository->save($user);