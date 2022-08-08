<?php

namespace MageSuite\NotificationDashboard\Model\ResourceModel;

class Cron
{
    protected \Magento\Framework\DB\Adapter\AdapterInterface $connection;

    public function __construct(\Magento\Framework\App\ResourceConnection $resourceConnection)
    {
        $this->connection = $resourceConnection->getConnection();
    }

    public function getCollectorSchedulerJobs()
    {
        $select = $this->connection
            ->select()
            ->from(['ndc' => $this->connection->getTableName('notification_dashboard_collector')], ['id', 'cron_expression'])
            ->where('ndc.is_enabled = ?', true);

        return $this->connection->fetchAll($select);
    }
}
