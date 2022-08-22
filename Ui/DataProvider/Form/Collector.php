<?php

namespace MageSuite\NotificationDashboard\Ui\DataProvider\Form;

class Collector extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected ?array $loadedData = null;

    /**
     * @var \MageSuite\NotificationDashboard\Model\ResourceModel\Collector\Collection
     */
    protected $collection;

    protected \Magento\Framework\Serialize\SerializerInterface $serializer;

    protected \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor;

    protected \MageSuite\NotificationDashboard\Api\CollectorUserRepositoryInterface $collectorUserRepository;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \MageSuite\NotificationDashboard\Model\ResourceModel\Collector\CollectionFactory $collectionFactory,
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \MageSuite\NotificationDashboard\Api\CollectorUserRepositoryInterface $collectorUserRepository,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->serializer = $serializer;
        $this->dataPersistor = $dataPersistor;
        $this->collectorUserRepository = $collectorUserRepository;
        $this->collection = $collectionFactory->create();
    }

    public function getConfigData()
    {
        return $this->data['config'] ?? [];
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $collector) {
            $loadedData = [
                'general' => $collector->getData()
            ];

            $loadedData['general']['users'] = $this->getCollectorUsers($collector->getId());

            if ($collector->getType() && $collector->getConfiguration()) {
                $loadedData[$collector->getType()] = $this->serializer->unserialize($collector->getConfiguration());
            }

            $this->loadedData[$collector->getId()] = $loadedData;
        }

        $data = $this->dataPersistor->get('notification_dashboard_collector');

        if (!empty($data)) {
            $collector = $this->collection->getNewEmptyItem();
            $collector->setData($data);
            $this->loadedData[$collector->getId()] = $collector->getData();
            $this->dataPersistor->clear('notification_dashboard_collector');
        }

        return $this->loadedData;
    }

    protected function getCollectorUsers($collectorId)
    {
        $collectorUsers = $this->collectorUserRepository->getByCollectorIds([$collectorId]);

        $result = ['users' => []];

        foreach ($collectorUsers as $collectorUser) {
            $result['users'][] = $collectorUser->getData();
        }

        return $result;
    }
}
