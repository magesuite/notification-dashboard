<?php

namespace MageSuite\NotificationDashboard\Model\Schedule;

class Jobs implements \MageSuite\Schedule\Model\Schedule\JobsGroupInterface
{
    protected \MageSuite\NotificationDashboard\Model\ResourceModel\Cron $cronResource;

    public function __construct(\MageSuite\NotificationDashboard\Model\ResourceModel\Cron $cronResource)
    {
        $this->cronResource = $cronResource;
    }

    public function execute()
    {
        return $this->cronResource->getCollectorSchedulerJobs();
    }
}
