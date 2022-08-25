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
            'label' => __('Save'),
            'class' => 'save primary',
            'class_name' => \Magento\Ui\Component\Control\Container::SPLIT_BUTTON,
            'options' => $this->getOptions(),
        ];
    }

    protected function getOptions()
    {
        $options[] = [
            'id_hard' => 'save_and_continue',
            'label' => __('Save'),
            'default' => true,
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
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

        $options[] = [
            'id_hard' => 'save',
            'label' => __('Save & Close'),
            'default' => false,
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'params' => [
                                    true
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $options;
    }
}
