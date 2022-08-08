<?php
namespace MageSuite\NotificationDashboard\Model\ResourceModel\CollectorUser;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \MageSuite\NotificationDashboard\Model\Data\CollectorUser::class,
            \MageSuite\NotificationDashboard\Model\ResourceModel\CollectorUser::class
        );
    }
}
