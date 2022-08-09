<?php

namespace MageSuite\NotificationDashboard\Service;

abstract class Processor implements ProcessorInterface
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

    abstract public function execute();

    public function setCollector($collector)
    {
        $this->collector = $collector;
    }

    public function getCollector()
    {
        return $this->collector;
    }

    public function setConfiguration($collector)
    {
        $configuration = $collector->getConfiguration();

        if (empty($configuration)) {
            throw new \MageSuite\NotificationDashboard\Exception\MissingCollectorConfiguration(
                __('Missing configuration for %1 (ID: %2) collector', $collector->getName(), $collector->getId())
            );
        }

        $this->configuration = $this->serializer->unserialize($configuration);
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }
}
