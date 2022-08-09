<?php
namespace MageSuite\NotificationDashboard\Block\Adminhtml\User\Edit;

class DeleteButton extends \MageSuite\NotificationDashboard\Block\Adminhtml\Button implements \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{
    public function getButtonData()
    {
        $userId = $this->request->getParam('id');

        if (!$userId || $this->isStatic()) {
            return [];
        }

        return [
            'label' => __('Delete'),
            'class' => 'delete',
            'on_click' => sprintf("deleteConfirm('%s', '%s')", __('Are you sure you want to do this?'), $this->getDeleteUrl($userId)),
            'sort_order' => 20,
        ];
    }

    public function getDeleteUrl($userId)
    {
        return $this->urlBuilder->getUrl('*/*/delete', ['id' => $userId]);
    }
}
