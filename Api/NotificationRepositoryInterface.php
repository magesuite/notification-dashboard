<?php
namespace MageSuite\NotificationDashboard\Api;

/**
 * @api
 */
interface NotificationRepositoryInterface
{
    /**
     * @param \MageSuite\NotificationDashboard\Model\Data\Notification $notification
     * @return \MageSuite\NotificationDashboard\Model\Data\Notification
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save($notification);

    /**
     * @param int $id
     * @return \MageSuite\NotificationDashboard\Model\Data\Notification
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param array $ids
     * @return bool true on success
     */
    public function markAsRead($ids);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null);

    /**
     * @param \MageSuite\NotificationDashboard\Model\Data\Notification $notification
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete($notification);

    /**
     * @param $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($id);

    /**
     * @param array $ids
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteByIds($ids);
}
