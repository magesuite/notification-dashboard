<?php

namespace MageSuite\NotificationDashboard\Block\Adminhtml\User\Edit;

class SaveButton extends \MageSuite\NotificationDashboard\Block\Adminhtml\Button implements \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{
    public function getButtonData()
    {
        if ($this->isStatic()) {
            return [];
        }

        return [
            'id_hard' => 'save',
            'label' => __('Save'),
            'class' => 'save primary'
        ];
    }
}
