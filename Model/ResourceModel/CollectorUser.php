<?php
namespace MageSuite\NotificationDashboard\Model\ResourceModel;

class CollectorUser extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('notification_dashboard_collector_user', \MageSuite\NotificationDashboard\Model\Data\CollectorUser::ID);
    }
}
