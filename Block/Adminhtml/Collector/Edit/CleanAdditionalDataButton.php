<?php

namespace MageSuite\NotificationDashboard\Block\Adminhtml\Collector\Edit;

class CleanAdditionalDataButton extends \MageSuite\NotificationDashboard\Block\Adminhtml\Button implements \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{
    public function getButtonData()
    {
        $collectorId = $this->request->getParam('id');

        if (!$collectorId || !$this->isAdditionalDataExist()) {
            return [];
        }

        return [
            'label' => __('Clean Additional Data'),
            'class' => 'delete',
            'on_click' => sprintf("deleteConfirm('%s', '%s')", __('Are you sure you want to do this?'), $this->getCleanAdditionalDataUrl($collectorId)),
            'sort_order' => 10,
        ];
    }

    public function getCleanAdditionalDataUrl($collectorId)
    {
        return $this->urlBuilder->getUrl('*/*/cleanAdditionalData', ['id' => $collectorId]);
    }

    protected function isAdditionalDataExist()
    {
        $currentEntity = $this->registry->registry('current_entity');

        if ($currentEntity && $currentEntity->getAdditionalData()) {
            return true;
        }

        return false;
    }
}
