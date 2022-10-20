<?php

namespace MageSuite\NotificationDashboard\Model\ResourceModel;

class Order
{
    protected \Magento\Framework\DB\Adapter\AdapterInterface $connection;

    public function __construct(\Magento\Framework\App\ResourceConnection $resourceConnection)
    {
        $this->connection = $resourceConnection->getConnection();
    }

    public function getOrdersWithNotPaidInvoice($maxDate, $minDate)
    {
        $select = $this->connection
            ->select()
            ->from(['si' => $this->connection->getTableName('sales_invoice')], ['created_at as invoice_created_at'])
            ->joinLeft(
                ['so' => $this->connection->getTableName('sales_order')],
                'si.order_id = so.entity_id',
                ['increment_id']
            )
            ->where('so.updated_at > ?', $minDate)
            ->where('so.updated_at < ?', $maxDate)
            ->where('si.state = ?', \Magento\Sales\Model\Order\Invoice::STATE_OPEN);

        return $this->connection->fetchAll($select);
    }

    public function getOrdersWithSpecificStatus($maxDate, $minDate, $status)
    {
        $select = $this->connection
            ->select()
            ->from(['so' => $this->connection->getTableName('sales_order')], ['increment_id', 'created_at'])
            ->where('so.updated_at > ?', $minDate)
            ->where('so.updated_at < ?', $maxDate)
            ->where('so.status = ?', $status);

        return $this->connection->fetchAll($select);
    }
}
