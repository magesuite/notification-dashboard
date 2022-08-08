<?php
namespace MageSuite\NotificationDashboard\Model;

class CollectorUserRepository implements \MageSuite\NotificationDashboard\Api\CollectorUserRepositoryInterface
{
    protected \MageSuite\NotificationDashboard\Model\ResourceModel\CollectorUser $resourceModel;

    protected \MageSuite\NotificationDashboard\Model\Data\CollectorUserFactory $collectorUserFactory;

    protected \MageSuite\NotificationDashboard\Model\ResourceModel\CollectorUser\CollectionFactory $collectionFactory;

    protected \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory;

    protected \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder;

    protected \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor;

    public function __construct(
        \MageSuite\NotificationDashboard\Model\ResourceModel\CollectorUser $resourceModel,
        \MageSuite\NotificationDashboard\Model\Data\CollectorUserFactory $collectorUserFactory,
        \MageSuite\NotificationDashboard\Model\ResourceModel\CollectorUser\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resourceModel = $resourceModel;
        $this->collectorUserFactory = $collectorUserFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function save($collectorUser)
    {
        try {
            $this->resourceModel->save($collectorUser);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($exception->getMessage()));
        }

        return $collectorUser;
    }

    public function getById($id)
    {
        $collectorUser = $this->collectorUserFactory->create();
        $this->resourceModel->load($collectorUser, $id);

        if (!$collectorUser->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('The collector user with the "%1" ID doesn\'t exist.', $id));
        }

        return $collectorUser;
    }

    public function getByCollectorIds($collectorIds)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(\MageSuite\NotificationDashboard\Model\Data\CollectorUser::COLLECTOR_ID, $collectorIds, 'in')
            ->create();

        $list = $this->getList($searchCriteria);

        if (!$list->getTotalCount()) {
            return [];
        }

        return $list->getItems();
    }

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

    public function delete($collectorUser)
    {
        try {
            $this->resourceModel->delete($collectorUser);
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
