<?php

namespace MageSuite\NotificationDashboard\Ui\Component\Listing\Notification;

class CollectorName extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected \MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository;

    protected $collectorIdNameMap = null;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);

        $this->collectorRepository = $collectorRepository;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        $fieldName = $this->getData('name');

        foreach ($dataSource['data']['items'] as &$item) {
            if (!isset($item['collector_id'])) {
                $item[$fieldName] = '';
                continue;
            }

            $item[$fieldName] = $this->getCollectorNameById($item['collector_id']);
        }

        return $dataSource;
    }

    protected function getCollectorNameById($collectorId)
    {
        if ($this->collectorIdNameMap === null) {
            $collectors = $this->collectorRepository->getList();
            $map = [];

            foreach ($collectors->getItems() as $collector) {
                $map[$collector->getId()] = $collector->getName();
            }

            $this->collectorIdNameMap = $map;
        }

        return $this->collectorIdNameMap[$collectorId] ?? null;
    }
}
