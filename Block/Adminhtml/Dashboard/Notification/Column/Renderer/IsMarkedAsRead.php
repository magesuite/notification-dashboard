<?php

namespace MageSuite\NotificationDashboard\Block\Adminhtml\Dashboard\Notification\Column\Renderer;

class IsMarkedAsRead extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    public function render(\Magento\Framework\DataObject $row)
    {
        $isRead = $this->_getValue($row);

        if ($isRead) {
            return __('Yes');
        }

        return __('No');
    }
}
