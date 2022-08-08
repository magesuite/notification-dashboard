<?php

namespace MageSuite\NotificationDashboard\Service;

interface ProcessorInterface
{
    /**
     * @param \MageSuite\NotificationDashboard\Model\Data\Collector $collector
     * @return void
     */
    public function setCollector($collector);

    /**
     * @return \MageSuite\NotificationDashboard\Model\Data\Collector
     */
    public function getCollector();

    /**
     * @param \MageSuite\NotificationDashboard\Model\Data\Collector $collector
     * @return void
     */
    public function setConfiguration($collector);

    /**
     * @return array
     */
    public function getConfiguration();

    /**
     * @return bool
     */
    public function execute();
}
