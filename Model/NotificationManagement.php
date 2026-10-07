<?php

declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Model;

class NotificationManagement
{
    public function __construct(
        protected \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository,
        protected \MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification
    ) {}

    public function addNotification(string $message, string $collectorName): void
    {
        $collector = $this->getCollector($collectorName);

        $this->addNotification->execute(
            $message,
            $collector->getId(),
            $collector->getSeverity(),
            $collector->getName(),
        );
    }

    public function getCollector(string $collectorName): \MageSuite\NotificationDashboard\Api\Data\CollectorInterface
    {
        return $this->collectorRepository->get($collectorName);
    }
}
