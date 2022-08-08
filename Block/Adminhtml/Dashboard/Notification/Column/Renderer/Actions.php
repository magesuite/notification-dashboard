<?php

namespace MageSuite\NotificationDashboard\Block\Adminhtml\Dashboard\Notification\Column\Renderer;

class Actions extends \Magento\Customer\Block\Adminhtml\Grid\Renderer\Multiaction
{
    public function render(\Magento\Framework\DataObject $row)
    {
        $actions = [
            [
                'url' => $this->getUrl('notification_dashboard/notification/markAsRead', [
                    'id' => $row->getId(),
                    'back_url' => $this->getUrl('*/dashboard/*')
                ]),
                'caption' => __('Mark as Read'),
            ],
            [
                'url' => $this->getUrl('notification_dashboard/notification/delete', [
                    'id' => $row->getId(),
                    'back_url' => $this->getUrl('*/dashboard/*')
                ]),
                'caption' => __('Delete'),
            ]
        ];

        $this->getColumn()->setActions($actions);

        return parent::render($row);
    }
}
