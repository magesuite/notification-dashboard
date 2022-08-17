<?php

namespace MageSuite\NotificationDashboard\Model;

class CollectorRepository implements \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface
{
    protected \MageSuite\NotificationDashboard\Model\ResourceModel\Collector $resourceModel;

    protected \MageSuite\NotificationDashboard\Model\Data\CollectorFactory $collectorFactory;

    protected \MageSuite\NotificationDashboard\Model\ResourceModel\Collector\CollectionFactory $collectionFactory;

    protected \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory;

    protected \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder;

    protected \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor;

    public function __construct(
        \MageSuite\NotificationDashboard\Model\ResourceModel\Collector $resourceModel,
        \MageSuite\NotificationDashboard\Model\Data\CollectorFactory $collectorFactory,
        \MageSuite\NotificationDashboard\Model\ResourceModel\Collector\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resourceModel = $resourceModel;
        $this->collectorFactory = $collectorFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save($collector)
    {
        try {
            $this->resourceModel->save($collector);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($exception->getMessage()));
        }

        return $collector;
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        $collector = $this->collectorFactory->create();
        $this->resourceModel->load($collector, $id);

        if (!$collector->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('The collector with the "%1" ID doesn\'t exist.', $id));
        }

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

    /**
     * @inheritDoc
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria = null)
    {
        $collection = $this->collectionFactory->create();

        if ($criteria === null) {
            $criteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($criteria, $collection);
        }

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete($collector)
    {
        try {
            $this->resourceModel->delete($collector);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }
}
