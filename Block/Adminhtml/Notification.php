<?php

namespace MageSuite\NotificationDashboard\Block\Adminhtml;

class Notification extends \Magento\Backend\Block\Template
{
    public function getViewAllUrl()
    {
        $collectionId = $this->getRequest()->getParam('collector_id');

        if (empty($collectionId)) {
            return null;
        }

        return $this->getUrl('*/*/index');
    }
}
