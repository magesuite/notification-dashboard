<?php

namespace MageSuite\NotificationDashboard\Model\Command\Notification;

abstract class CollectAndSend implements CollectAndSendInterface
{
    protected \Magento\Framework\Serialize\SerializerInterface $serializer;

    protected \MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification;

    protected $collector = null;
    protected $configuration = null;

    public function __construct(
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification
    ) {
        $this->serializer = $serializer;
        $this->addNotification = $addNotification;
    }

    /**
     * @inheritDoc
     */
    public function setCollector(\MageSuite\NotificationDashboard\Model\Data\Collector $collector)
    {
        $this->collector = $collector;
    }

    /**
     * @inheritDoc
     */
    public function getCollector()
    {
        return $this->collector;
    }

    /**
     * @inheritDoc
     */
    public function setConfiguration(\MageSuite\NotificationDashboard\Model\Data\Collector $collector)
    {
        $configuration = $collector->getConfiguration();

        if (empty($configuration)) {
            throw new \MageSuite\NotificationDashboard\Exception\MissingCollectorConfiguration(
                __('Missing configuration for %1 (ID: %2) collector', $collector->getName(), $collector->getId())
            );
        }

        $this->configuration = $this->serializer->unserialize($configuration);
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}
