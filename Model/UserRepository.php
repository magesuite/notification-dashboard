<?php

declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Model;

class UserRepository extends \MageSuite\NotificationDashboard\Model\AbstractRepository implements \MageSuite\NotificationDashboard\Api\UserRepositoryInterface
{
    protected array $users = [];

    public function __construct(
        \MageSuite\NotificationDashboard\Model\ResourceModel\User $resourceModel,
        protected \MageSuite\NotificationDashboard\Model\Data\UserFactory $userFactory,
        protected \MageSuite\NotificationDashboard\Model\ResourceModel\User\CollectionFactory $collectionFactory,
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
        if (isset($this->users[$id])) {
            return $this->users[$id];
        }

        $user = $this->userFactory->create();
        $this->resourceModel->load($user, $id);

        if (!$user->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('The user with the "%1" ID doesn\'t exist.', $id));
        }

        $this->users[$id] = $user;
        return $this->users[$id];
    }
}
