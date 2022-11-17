<?php
declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Model\ResourceModel;

class Cron
{
    protected \Magento\Framework\DB\Adapter\AdapterInterface $connection;

    public function __construct(\Magento\Framework\App\ResourceConnection $resourceConnection)
    {
        $this->connection = $resourceConnection->getConnection();
    }

    public function getCollectorSchedulerJobs(): array
    {
        $select = $this->connection
            ->select()
            ->from($this->connection->getTableName('notification_dashboard_collector'), ['id', 'cron_expression'])
            ->where('is_enabled = ?', 1)
            ->where('cron_expression IS NOT NULL')
            ->where('type IS NOT NULL');

        return $this->connection->fetchAll($select);
    }
}
