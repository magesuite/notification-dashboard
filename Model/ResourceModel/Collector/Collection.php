<?php

namespace MageSuite\NotificationDashboard\Model\ResourceModel\Collector;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \MageSuite\NotificationDashboard\Model\Data\Collector::class,
            \MageSuite\NotificationDashboard\Model\ResourceModel\Collector::class
        );
    }
}
