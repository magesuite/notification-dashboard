<?php
namespace MageSuite\NotificationDashboard\Model;

class NotificationRepository implements \MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface
{
    protected \MageSuite\NotificationDashboard\Model\ResourceModel\Notification $resourceModel;

    protected \MageSuite\NotificationDashboard\Model\Data\NotificationFactory $notificationFactory;

    protected \MageSuite\NotificationDashboard\Model\ResourceModel\Notification\CollectionFactory $collectionFactory;

    protected \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory;

    protected \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder;

    protected \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor;

    public function __construct(
        \MageSuite\NotificationDashboard\Model\ResourceModel\Notification $resourceModel,
        \MageSuite\NotificationDashboard\Model\Data\NotificationFactory $notificationFactory,
        \MageSuite\NotificationDashboard\Model\ResourceModel\Notification\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resourceModel = $resourceModel;
        $this->notificationFactory = $notificationFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function save($notification)
    {
        try {
            $this->resourceModel->save($notification);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($exception->getMessage()));
        }

        return $notification;
    }

    public function getById($id)
    {
        $notification = $this->notificationFactory->create();
        $this->resourceModel->load($notification, $id);

        if (!$notification->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('The notification with the "%1" ID doesn\'t exist.', $id));
        }

        return $notification;
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

    public function markAsRead($ids)
    {
        try {
            foreach ($this->getNotificationsByIds($ids) as $notification) {
                $notification->setIsRead(true);
                $this->save($notification);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete($notification)
    {
        try {
            $this->resourceModel->delete($notification);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    public function deleteByIds($ids)
    {
        try {
            foreach ($this->getNotificationsByIds($ids) as $notification) {
                $this->resourceModel->delete($notification);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function getNotificationsByIds($ids)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(\MageSuite\NotificationDashboard\Api\Data\NotificationInterface::ID, $ids)
            ->create();

        $notificationList = $this->getList($searchCriteria);

        if (!$notificationList->getTotalCount()) {
            return [];
        }

        return $notificationList->getItems();
    }
}
