<?php

namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Collector;

class Index extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    public function execute()
    {
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('MageSuite_NotificationDashboard::collector');
        $resultPage->addBreadcrumb(__('Collectors'), __('Collectors'));
        $resultPage->getConfig()->getTitle()->prepend(__('Collectors'));

        return $resultPage;
    }
}
