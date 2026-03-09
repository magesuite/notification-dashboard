<?php

declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Test\Fixture;

use Magento\Framework\DataObject;
use Magento\TestFramework\Fixture\DataFixtureInterface;
use MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface;
use MageSuite\NotificationDashboard\Model\Data\CollectorFactory;
use MageSuite\NotificationDashboard\Model\Source\Severity;

class Collector implements DataFixtureInterface
{
    protected const DEFAULT_COLLECTOR = [
        'is_enabled' => true,
        'name' => 'Test Collector',
        'type' => 'test_item',
        'is_static' => false,
        'cron_expression' => '30 */4 * * *',
        'visible_on_dashboard' => false,
        'severity' => Severity::SEVERITY_CRITICAL,
    ];

    protected const DEFAULT_STATIC_COLLECTOR = [
        'is_enabled' => true,
        'name' => 'Static Collector',
        'type' => 'test_item',
        'is_static' => true,
        'cron_expression' => '0 * * * *',
        'visible_on_dashboard' => false,
        'severity' => Severity::SEVERITY_NOTICE,
    ];

    public function __construct(
        private readonly CollectorFactory $collectorFactory,
        private readonly CollectorRepositoryInterface $collectorRepository,
    ) {}

    public function apply(array $data = []): ?DataObject
    {
        if (isset($data['collectors'])) {
            $collectorsData = $data['collectors'];
        } else {
            $collectorsData = [
                array_replace(self::DEFAULT_COLLECTOR, $data),
                self::DEFAULT_STATIC_COLLECTOR,
            ];
        }

        $collectors = [];
        foreach ($collectorsData as $collectorData) {
            $collector = $this->collectorFactory->create();
            $collector->isObjectNew(true);
            $collector
                ->setIsEnabled($collectorData['is_enabled'])
                ->setName($collectorData['name'])
                ->setType($collectorData['type'])
                ->setIsStatic($collectorData['is_static'])
                ->setCronExpression($collectorData['cron_expression'])
                ->setVisibleOnDashboard($collectorData['visible_on_dashboard'])
                ->setSeverity($collectorData['severity']);

            $this->collectorRepository->save($collector);
            $collectors[] = $collector;
        }

        return new DataObject(['collectors' => $collectors]);
    }
}
