<?php
namespace MageSuite\NotificationDashboard\Block\Adminhtml\Collector\Edit;

class SaveButton extends \MageSuite\NotificationDashboard\Block\Adminhtml\Button
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
