<?php

namespace MageSuite\NotificationDashboard\Service\Notification\Channel;

class AddAdminNotification
{
    protected $severityMap = [
        \MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_CRITICAL => \Magento\Framework\Notification\MessageInterface::SEVERITY_CRITICAL,
        \MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_MAJOR => \Magento\Framework\Notification\MessageInterface::SEVERITY_MAJOR,
        \MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_MINOR => \Magento\Framework\Notification\MessageInterface::SEVERITY_MINOR,
        \MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_NOTICE => \Magento\Framework\Notification\MessageInterface::SEVERITY_NOTICE
    ];

    protected \MageSuite\NotificationDashboard\Model\Command\Notification\AddRawDataToMessage $addRawDataToMessage;

    protected \Magento\AdminNotification\Model\Inbox $adminNotification;

    protected \MageSuite\NotificationDashboard\Logger\Logger $logger;

    public function __construct(
        \MageSuite\NotificationDashboard\Model\Command\Notification\AddRawDataToMessage $addRawDataToMessage,
        \Magento\AdminNotification\Model\Inbox $adminNotification,
        \MageSuite\NotificationDashboard\Logger\Logger $logger
    ) {
        $this->addRawDataToMessage = $addRawDataToMessage;
        $this->adminNotification = $adminNotification;
        $this->logger = $logger;
    }

    public function execute($notification)
    {
        $message = $this->addRawDataToMessage->execute($notification);

        $severity = $notification->getSeverity();
        $severity = $this->severityMap[$severity] ?? null;

        $this->adminNotification->add(
            $severity,
            $notification->getTitle(),
            $message
        );

        $this->logger->error($message);
    }
}
