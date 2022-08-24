<?php

namespace MageSuite\NotificationDashboard\Block\Adminhtml\Collector\Edit;

class SaveButton extends \MageSuite\NotificationDashboard\Block\Adminhtml\Button implements \Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface
{
    public function getButtonData()
    {
        if ($this->isStatic()) {
            return [];
        }

        return [
            'id_hard' => 'save_and_continue',
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'collector_form.collector_form',
                                'actionName' => 'save',
                                'params' => [
                                    true,
                                    [
                                        'back' => 'continue'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
