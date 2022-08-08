<?php

namespace MageSuite\NotificationDashboard\Model\Command\Notification;

class AddNotification
{
    protected \MageSuite\NotificationDashboard\Model\Data\NotificationFactory $notificationFactory;

    protected \MageSuite\NotificationDashboard\Model\NotificationRepository $notificationRepository;

    protected \MageSuite\NotificationDashboard\Service\Notification\Processor $notificationProcessor;

    public function __construct(
        \MageSuite\NotificationDashboard\Model\Data\NotificationFactory $notificationFactory,
        \MageSuite\NotificationDashboard\Model\NotificationRepository $notificationRepository,
        \MageSuite\NotificationDashboard\Service\Notification\Processor $notificationProcessor
    ) {
        $this->notificationFactory = $notificationFactory;
        $this->notificationRepository = $notificationRepository;
        $this->notificationProcessor = $notificationProcessor;
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
        $this->notificationProcessor->execute([$notification]);
    }
}
