<?php
namespace MageSuite\NotificationDashboard\Model\Source;

class Collector implements \Magento\Framework\Data\OptionSourceInterface
{
    protected \MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository;

    protected ?array $options = null;

    public function __construct(\MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository)
    {
        $this->collectorRepository = $collectorRepository;
    }

    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $collectors = $this->collectorRepository->getList();
        $options = [];

        foreach ($collectors->getItems() as $collector) {
            $options[] = [
                'value' => $collector->getId(),
                'label' => $collector->getName()
            ];
        }

        $this->options = $options;
        return $this->options;
    }
}
