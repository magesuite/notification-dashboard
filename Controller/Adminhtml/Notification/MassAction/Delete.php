<?php

declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Notification\MassAction;

class Delete extends \MageSuite\NotificationDashboard\Controller\Adminhtml\Notification\MassAction\AbstractMassAction
{
    protected function performAction(array $ids): void
    {
        $this->notificationRepository->deletebyIds($ids);
    }

    protected function getSuccessMessage(): \Magento\Framework\Phrase
    {
        return __('You deleted the notifications.');
    }
}
