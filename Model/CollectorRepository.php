<?php

declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Model;

class CollectorRepository extends \MageSuite\NotificationDashboard\Model\AbstractRepository implements \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface
{
    protected array $collectors = [];

    protected array $collectorsByName = [];

    public function __construct(
        \MageSuite\NotificationDashboard\Model\ResourceModel\Collector $resourceModel,
        protected \MageSuite\NotificationDashboard\Model\Data\CollectorFactory $collectorFactory,
        protected \MageSuite\NotificationDashboard\Model\ResourceModel\Collector\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    ) {
        parent::__construct($resourceModel, $searchResultsFactory, $searchCriteriaBuilder, $collectionProcessor);
    }

    protected function createCollection(): \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
    {
        return $this->collectionFactory->create();
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        if (isset($this->collectors[$id])) {
            return $this->collectors[$id];
        }

        $collector = $this->collectorFactory->create();
        $this->resourceModel->load($collector, $id);

        if (!$collector->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('The collector with the "%1" ID doesn\'t exist.', $id)
            );
        }

        $this->collectors[$id] = $collector;
        $this->collectorsByName[$collector->getName()] = $collector;

        return $this->collectors[$id];
    }

    /**
     * @inheritDoc
     */
    public function get(string $name)
    {
        if (isset($this->collectorsByName[$name])) {
            return $this->collectorsByName[$name];
        }

        $collector = $this->collectorFactory->create();
        $this->resourceModel->load($collector, $name, \MageSuite\NotificationDashboard\Api\Data\CollectorInterface::NAME);

        if (!$collector->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('The collector with the "%1" name doesn\'t exist.', $name)
            );
        }

        $this->collectors[$collector->getId()] = $collector;
        $this->collectorsByName[$name] = $collector;

        return $collector;
    }

    /**
     * @inheritDoc
     */
    public function getByIds($ids)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(\MageSuite\NotificationDashboard\Api\Data\CollectorInterface::ID, $ids, 'in')
            ->create();

        $list = $this->getList($searchCriteria);

        if (!$list->getTotalCount()) {
            return [];
        }

        return $list->getItems();
    }

    /**
     * @inheritDoc
     */
    public function getCollectorsVisibleOnDashboard()
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(\MageSuite\NotificationDashboard\Api\Data\CollectorInterface::VISIBLE_ON_DASHBOARD, true)
            ->create();

        $list = $this->getList($searchCriteria);

        if (!$list->getTotalCount()) {
            return [];
        }

        return $list->getItems();
    }
}
