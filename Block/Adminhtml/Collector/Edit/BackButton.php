<?php
namespace MageSuite\NotificationDashboard\Block\Adminhtml\Collector\Edit;

class BackButton extends \MageSuite\NotificationDashboard\Block\Adminhtml\Button
{
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    public function getBackUrl()
    {
        return $this->urlBuilder->getUrl('*/*/');
    }
}
