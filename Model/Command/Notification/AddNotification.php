<?php

namespace MageSuite\NotificationDashboard\Model\Command\Notification;

class AddNotification
{
    protected \MageSuite\NotificationDashboard\Model\Data\NotificationFactory $notificationFactory;

    protected \MageSuite\NotificationDashboard\Model\NotificationRepository $notificationRepository;

    protected \MageSuite\NotificationDashboard\Service\NotificationSender\SenderResolver $notificationSenderResolver;

    public function __construct(
        \MageSuite\NotificationDashboard\Model\Data\NotificationFactory $notificationFactory,
        \MageSuite\NotificationDashboard\Model\NotificationRepository $notificationRepository,
        \MageSuite\NotificationDashboard\Service\NotificationSender\SenderResolver $notificationSenderResolver
    ) {
        $this->notificationFactory = $notificationFactory;
        $this->notificationRepository = $notificationRepository;
        $this->notificationSenderResolver = $notificationSenderResolver;
    }

    public function execute($message, $collectorId, $severity, $title = null) //phpcs:ignore
    {
        if (!$title) {
            $title = __('Notification');
        }

        $notification = $this->notificationFactory->create();

        $notification
            ->setTitle($title)
            ->setMessage($message)
            ->setCollectorId($collectorId)
            ->setSeverity($severity);

        $notification = $this->notificationRepository->save($notification);
        $this->notificationSenderResolver->resolve([$notification]);
    }
}
