<?php

namespace MageSuite\NotificationDashboard\Test\Integration\Model\Collector;

class TypeResolverTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\TestFramework\ObjectManager $objectManager;

    protected function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoDataFixture MageSuite_NotificationDashboard::Test/Integration/_files/collector.php
     */
    public function testItReturnsCorrectJobs()
    {
        $collectorTypes = [
            'missing_data' => [
                'label' => 'Missing data',
                'processor' => 'Dummy class',
                'sortOrder' => 10
            ],
            'too_many_items' => [
                'label' => 'Too many items',
                'processor' => 'Another dummy class',
                'sortOrder' => 20
            ]
        ];

        /** @var \MageSuite\NotificationDashboard\Model\Collector\TypeResolver $typeResolver */
        $typeResolver = $this->objectManager->create(
            \MageSuite\NotificationDashboard\Model\Collector\TypeResolver::class,
            [
                'collectorTypes' => $collectorTypes
            ]
        );

        $types = $typeResolver->getCollectorTypes();

        $this->assertCount(2, $types);
        $this->assertEquals('Dummy class', $types['missing_data']['processor']);
        $this->assertEquals('Too many items', $types['too_many_items']['label']);

        $processor = $typeResolver->getProcessorInstance('too_many_items');
        $this->assertEquals('Another dummy class', $processor);
    }
}