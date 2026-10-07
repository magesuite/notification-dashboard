<?php

declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Model;

abstract class AbstractRepository
{
    public function __construct(
        protected \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resourceModel,
        protected \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        protected \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        protected \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    ) {}

    abstract public function getById($id);

    abstract protected function createCollection(): \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

    public function save($entity)
    {
        try {
            $this->resourceModel->save($entity);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($exception->getMessage()));
        }

        return $entity;
    }

    public function getList(?\Magento\Framework\Api\SearchCriteriaInterface $criteria = null)
    {
        $collection = $this->createCollection();

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

    public function delete($entity)
    {
        try {
            $this->resourceModel->delete($entity);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }
}
