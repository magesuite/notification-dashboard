<?php

namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Dashboard;

class Index extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    public function execute()
    {
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('MageSuite_NotificationDashboard::dashboard');
        $resultPage->addBreadcrumb(__('Dashboard'), __('Dashboard'));
        $resultPage->getConfig()->getTitle()->prepend(__('Dashboard'));

        return $resultPage;
    }
}
