<?php

declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Model;

class CollectorUserRepository extends \MageSuite\NotificationDashboard\Model\AbstractRepository implements \MageSuite\NotificationDashboard\Api\CollectorUserRepositoryInterface
{
    protected array $collectorUsers = [];

    public function __construct(
        \MageSuite\NotificationDashboard\Model\ResourceModel\CollectorUser $resourceModel,
        protected \MageSuite\NotificationDashboard\Model\Data\CollectorUserFactory $collectorUserFactory,
        protected \MageSuite\NotificationDashboard\Model\ResourceModel\CollectorUser\CollectionFactory $collectionFactory,
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
        if (isset($this->collectorUsers[$id])) {
            return $this->collectorUsers[$id];
        }

        $collectorUser = $this->collectorUserFactory->create();
        $this->resourceModel->load($collectorUser, $id);

        if (!$collectorUser->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('The collector user with the "%1" ID doesn\'t exist.', $id));
        }

        $this->collectorUsers[$id] = $collectorUser;
        return $this->collectorUsers[$id];
    }

    /**
     * @inheritDoc
     */
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
}
