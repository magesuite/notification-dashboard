<?php
declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Model\Source;

class Collector implements \Magento\Framework\Data\OptionSourceInterface
{
    protected \MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository;

    protected ?array $options = null;

    public function __construct(\MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository)
    {
        $this->collectorRepository = $collectorRepository;
    }

    public function toOptionArray(): array
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $collectors = $this->collectorRepository->getList();
        $this->options = [];

        foreach ($collectors->getItems() as $collector) {
            $this->options[] = [
                'value' => $collector->getId(),
                'label' => $collector->getName()
            ];
        }

        return $this->options;
    }
}
