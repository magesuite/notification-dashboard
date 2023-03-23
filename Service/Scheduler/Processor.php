<?php

namespace MageSuite\NotificationDashboard\Service\Scheduler;

class Processor
{
    protected \MageSuite\NotificationDashboard\Helper\Configuration $configuration;

    protected \MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository;

    protected \MageSuite\NotificationDashboard\Model\Collector\TypeResolver $collectorTypeResolver;

    protected \MageSuite\NotificationDashboard\Logger\Logger $logger;

    public function __construct(
        \MageSuite\NotificationDashboard\Helper\Configuration $configuration,
        \MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository,
        \MageSuite\NotificationDashboard\Model\Collector\TypeResolver $collectorTypeResolver,
        \MageSuite\NotificationDashboard\Logger\Logger $logger
    ) {
        $this->configuration = $configuration;
        $this->collectorRepository = $collectorRepository;
        $this->collectorTypeResolver = $collectorTypeResolver;
        $this->logger = $logger;
    }

    public function execute($collectorId)
    {
        if (!$this->configuration->isEnabled()) {
            return;
        }

        try {
            $commandInstance = $this->getCommandInstance($collectorId);
            $commandInstance->execute();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->logger->critical(sprintf('Can`t found collector with id: %s', $collectorId));
        } catch (\Magento\Framework\Exception\LocalizedException $e) { // phpcs:ignore Magento2.CodeAnalysis.EmptyBlock
        }
    }

    public function getCommandInstance($collectorId)
    {
        $collector = $this->collectorRepository->getById((int)$collectorId);

        if (!$collector->getIsEnabled()) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Collector with ID: %1 is not enabled.', $collectorId)
            );
        }

        if (!$collector->getType()) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Type is not defined for collector with ID: %1.', $collectorId)
            );
        }

        $commandInstance = $this->collectorTypeResolver->getCommandInstance($collector->getType());
        $commandInstance->setCollector($collector);
        $commandInstance->setConfiguration($collector);

        return $commandInstance;
    }
}
