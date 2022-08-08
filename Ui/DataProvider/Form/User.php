<?php
namespace MageSuite\NotificationDashboard\Ui\DataProvider\Form;

class User extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected ?array $loadedData = null;

    /**
     * @var \MageSuite\NotificationDashboard\Model\ResourceModel\User\Collection
     */
    protected $collection;

    protected \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \MageSuite\NotificationDashboard\Model\ResourceModel\User\CollectionFactory $collectionFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $user) {
            $this->loadedData[$user->getId()] = [
                'general' => $user->getData()
            ];
        }

        $data = $this->dataPersistor->get('notification_dashboard_user');

        if (!empty($data)) {
            $user = $this->collection->getNewEmptyItem();
            $user->setData($data);
            $this->loadedData[$user->getId()] = $user->getData();
            $this->dataPersistor->clear('notification_dashboard_user');
        }

        return $this->loadedData;
    }
}
