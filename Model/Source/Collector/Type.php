<?php
declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Model\Source\Collector;

class Type implements \Magento\Framework\Data\OptionSourceInterface
{
    protected \MageSuite\NotificationDashboard\Model\Collector\TypeResolver $collectorTypeResolver;

    protected ?array $options = null;

    public function __construct(\MageSuite\NotificationDashboard\Model\Collector\TypeResolver $collectorTypeResolver)
    {
        $this->collectorTypeResolver = $collectorTypeResolver;
    }

    public function toOptionArray(): array
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $collectorTypes = $this->collectorTypeResolver->getCollectorTypes();
        $this->options = [
            [
                'value' => '',
                'label' => __('None')
            ]
        ];

        foreach ($collectorTypes as $collectorType => $collector) {
            $this->options[] = [
                'value' => $collectorType,
                'label' => $collector['label']
            ];
        }

        usort($this->options, function ($a, $b) {
            return strcmp((string)$a['label'], (string)$b['label']);
        });

        return $this->options;
    }
}
