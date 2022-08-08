<?php
namespace MageSuite\NotificationDashboard\Api;

/**
 * @api
 */
interface UserRepositoryInterface
{
    /**
     * @param \MageSuite\NotificationDashboard\Model\Data\User $user
     * @return \MageSuite\NotificationDashboard\Model\Data\User
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save($user);

    /**
     * @param int $id
     * @return \MageSuite\NotificationDashboard\Model\Data\User
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null);

    /**
     * @param \MageSuite\NotificationDashboard\Model\Data\User $user
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete($user);

    /**
     * @param $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($id);
}
