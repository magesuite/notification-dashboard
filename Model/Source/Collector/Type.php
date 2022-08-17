<?php

namespace MageSuite\NotificationDashboard\Model\Source\Collector;

class Type implements \Magento\Framework\Data\OptionSourceInterface
{
    protected \MageSuite\NotificationDashboard\Model\Collector\TypeResolver $collectorTypeResolver;

    protected ?array $options = null;

    public function __construct(\MageSuite\NotificationDashboard\Model\Collector\TypeResolver $collectorTypeResolver)
    {
        $this->collectorTypeResolver = $collectorTypeResolver;
    }

    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $collectorTypes = $this->collectorTypeResolver->getCollectorTypes();

        $options = [
            [
                'value' => '',
                'label' => __('-- Please Select --')
            ]
        ];

        foreach ($collectorTypes as $collectorType => $collector) {
            $options[] = [
                'value' => $collectorType,
                'label' => $collector['label']
            ];
        }

        usort($options, function ($a, $b) {
            return strcmp($a['label'], $b['label']);
        });

        $this->options = $options;
        return $this->options;
    }
}
