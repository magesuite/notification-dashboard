<?php

namespace MageSuite\NotificationDashboard\Model\ResourceModel\User;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \MageSuite\NotificationDashboard\Model\Data\User::class,
            \MageSuite\NotificationDashboard\Model\ResourceModel\User::class
        );
    }
}
