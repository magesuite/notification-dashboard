<?php

namespace MageSuite\NotificationDashboard\Api;

/**
 * @api
 */
interface CollectorUserRepositoryInterface
{
    /**
     * @param \MageSuite\NotificationDashboard\Model\Data\CollectorUser $collectorUser
     * @return \MageSuite\NotificationDashboard\Model\Data\CollectorUser
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save($collector);

    /**
     * @param int $id
     * @return \MageSuite\NotificationDashboard\Model\Data\CollectorUser
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param array $collectorId
     * @return \MageSuite\NotificationDashboard\Model\Data\CollectorUser
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByCollectorIds($collectorIds);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null);

    /**
     * @param \MageSuite\NotificationDashboard\Model\Data\CollectorUser $collectorUser
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete($collectorUser);

    /**
     * @param $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($id);
}
