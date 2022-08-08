<?php
namespace MageSuite\NotificationDashboard\Service\Scheduler;

class Processor
{
    protected \MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository;

    protected \MageSuite\NotificationDashboard\Model\Collector\TypeResolver $collectorTypeResolver;

    protected \MageSuite\NotificationDashboard\Logger\Logger $logger;

    public function __construct(
        \MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository,
        \MageSuite\NotificationDashboard\Model\Collector\TypeResolver $collectorTypeResolver,
        \MageSuite\NotificationDashboard\Logger\Logger $logger
    ) {
        $this->collectorRepository = $collectorRepository;
        $this->collectorTypeResolver = $collectorTypeResolver;
        $this->logger = $logger;
    }

    public function execute($collectorId)
    {
        $processorInstance = $this->getProcessorInstance($collectorId);

        if (empty($processorInstance)) {
            return null;
        }

        $processorInstance->execute();
    }

    public function getProcessorInstance($collectorId)
    {
        try {
            $collector = $this->collectorRepository->getById((int)$collectorId);

            if (!$collector->getIsEnabled()) {
                return null;
            }

            $processorInstance = $this->collectorTypeResolver->getProcessorInstance($collector->getType());

            $processorInstance->setCollector($collector);
            $processorInstance->setConfiguration($collector);
            
            return $processorInstance;
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->logger->critical(sprintf('Can`t found collector with id: %s', $collectorId));
            return null;
        }
    }
}
