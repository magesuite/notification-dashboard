<?php

declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Notification\MassAction;

class MarkAsRead extends \MageSuite\NotificationDashboard\Controller\Adminhtml\Notification\MassAction\AbstractMassAction
{
    protected function performAction(array $ids): void
    {
        $this->notificationRepository->markAsRead($ids);
    }

    protected function getSuccessMessage(): \Magento\Framework\Phrase
    {
        return __('You marked notifications as read.');
    }
}
