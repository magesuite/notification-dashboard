<?php

namespace MageSuite\NotificationDashboard\Model\Source;

class IsMarkedAsRead implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label'=> __('No')],
            ['value' => 1, 'label'=> __('Yes')]
        ];
    }
}
