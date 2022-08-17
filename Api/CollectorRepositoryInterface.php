<?php

namespace MageSuite\NotificationDashboard\Api;

/**
 * @api
 */
interface CollectorRepositoryInterface
{
    /**
     * @param \MageSuite\NotificationDashboard\Model\Data\Collector $collector
     * @return \MageSuite\NotificationDashboard\Model\Data\Collector
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save($collector);

    /**
     * @param int $id
     * @return \MageSuite\NotificationDashboard\Model\Data\Collector
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param array $ids
     * @return \MageSuite\NotificationDashboard\Model\Data\Collector[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByIds($ids);

    /**
     * @return \MageSuite\NotificationDashboard\Model\Data\Collector[]
     */
    public function getCollectorsVisibleOnDashboard();

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null);

    /**
     * @param \MageSuite\NotificationDashboard\Model\Data\Collector $collector
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete($collector);

    /**
     * @param $id
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($id);
}
