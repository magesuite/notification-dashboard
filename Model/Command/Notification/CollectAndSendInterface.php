<?php

namespace MageSuite\NotificationDashboard\Model\Command\Notification;

interface CollectAndSendInterface
{
    /**
     * @param \MageSuite\NotificationDashboard\Model\Data\Collector $collector
     * @return void
     */
    public function setCollector(\MageSuite\NotificationDashboard\Model\Data\Collector $collector);

    /**
     * @return \MageSuite\NotificationDashboard\Model\Data\Collector
     */
    public function getCollector();

    /**
     * @param \MageSuite\NotificationDashboard\Model\Data\Collector $collector
     * @return void
     */
    public function setConfiguration(\MageSuite\NotificationDashboard\Model\Data\Collector $collector);

    /**
     * @return array
     */
    public function getConfiguration();

    /**
     * @return bool
     */
    public function execute();
}
