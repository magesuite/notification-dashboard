<?php

namespace MageSuite\NotificationDashboard\Model\ResourceModel;

class Notification extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('notification_dashboard_notification', \MageSuite\NotificationDashboard\Api\Data\NotificationInterface::ID);
    }

    public function getCollectorNameById($collectorId)
    {
        $connection = $this->getConnection();

        $select = $connection
            ->select()
            ->from(['ndc' => $connection->getTableName('notification_dashboard_collector')], ['name'])
            ->where('id = ?', $collectorId);

        return $connection->fetchOne($select);
    }
}
