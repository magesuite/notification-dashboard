<?php
namespace MageSuite\NotificationDashboard\Block\Adminhtml\Collector\Edit;

class DeleteButton extends \MageSuite\NotificationDashboard\Block\Adminhtml\Button
{
    public function getButtonData()
    {
        $collectorId = $this->request->getParam('id');

        if (!$collectorId || $this->isStatic()) {
            return [];
        }

        return [
            'label' => __('Delete'),
            'class' => 'delete',
            'on_click' => sprintf("deleteConfirm('%s', '%s')", __('Are you sure you want to do this?'), $this->getDeleteUrl($collectorId)),
            'sort_order' => 20,
        ];
    }

    public function getDeleteUrl($collectorId)
    {
        return $this->urlBuilder->getUrl('*/*/delete', ['id' => $collectorId]);
    }
}
