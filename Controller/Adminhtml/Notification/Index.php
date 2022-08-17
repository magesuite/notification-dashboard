<?php

namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Notification;

class Index extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    protected \MageSuite\NotificationDashboard\Model\ResourceModel\Notification $notificationResource;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MageSuite\NotificationDashboard\Model\ResourceModel\Notification $notificationResource
    ) {
        parent::__construct($context);

        $this->notificationResource = $notificationResource;
    }

    public function execute()
    {
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);

        $title = __('Notifications');
        $collectorId = $this->getRequest()->getParam('collector_id');

        if ($collectorId) {
            $title = sprintf(
                '%s (Filtered by collector: %s)',
                $title,
                $this->notificationResource->getCollectorNameById($collectorId)
            );
        }

        $resultPage->setActiveMenu('MageSuite_NotificationDashboard::notification');
        $resultPage->addBreadcrumb($title, $title);
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
