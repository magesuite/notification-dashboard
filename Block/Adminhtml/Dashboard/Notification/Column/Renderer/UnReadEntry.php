<?php

namespace MageSuite\NotificationDashboard\Block\Adminhtml\Dashboard\Notification\Column\Renderer;

class UnReadEntry extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    public function render(\Magento\Framework\DataObject $row)
    {
        $rowValue = parent::render($row);

        $isRead = $row->getIsRead();

        if ($isRead) {
            return $rowValue;
        }

        return sprintf('<strong>%s</strong>', $rowValue);
    }
}
