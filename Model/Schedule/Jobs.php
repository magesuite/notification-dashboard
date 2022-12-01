<?php

namespace MageSuite\NotificationDashboard\Model\Schedule;

class Jobs implements \MageSuite\Schedule\Model\Schedule\JobsGroupInterface
{
    protected \MageSuite\NotificationDashboard\Helper\Configuration $configuration;

    protected \MageSuite\NotificationDashboard\Model\ResourceModel\Cron $cronResource;

    public function __construct(
        \MageSuite\NotificationDashboard\Helper\Configuration $configuration,
        \MageSuite\NotificationDashboard\Model\ResourceModel\Cron $cronResource
    ) {
        $this->configuration = $configuration;
        $this->cronResource = $cronResource;
    }

    public function execute()
    {
        if (!$this->configuration->isEnabled()) {
            return [];
        }

        return $this->cronResource->getCollectorSchedulerJobs();
    }
}
