<?php
namespace MageSuite\NotificationDashboard\Model;

class UserRepository implements \MageSuite\NotificationDashboard\Api\UserRepositoryInterface
{
    protected \MageSuite\NotificationDashboard\Model\ResourceModel\User $resourceModel;

    protected \MageSuite\NotificationDashboard\Model\Data\UserFactory $userFactory;

    protected \MageSuite\NotificationDashboard\Model\ResourceModel\User\CollectionFactory $collectionFactory;

    protected \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory;

    protected \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder;

    protected \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor;

    public function __construct(
        \MageSuite\NotificationDashboard\Model\ResourceModel\User $resourceModel,
        \MageSuite\NotificationDashboard\Model\Data\UserFactory $userFactory,
        \MageSuite\NotificationDashboard\Model\ResourceModel\User\CollectionFactory $collectionFactory,
        \Magento\Framework\Api\SearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resourceModel = $resourceModel;
        $this->userFactory = $userFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function save($user)
    {
        try {
            $this->resourceModel->save($user);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($exception->getMessage()));
        }

        return $user;
    }

    public function getById($id)
    {
        $user = $this->userFactory->create();
        $this->resourceModel->load($user, $id);

        if (!$user->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('The user with the "%1" ID doesn\'t exist.', $id));
        }

        return $user;
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

    public function delete($user)
    {
        try {
            $this->resourceModel->delete($user);
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
