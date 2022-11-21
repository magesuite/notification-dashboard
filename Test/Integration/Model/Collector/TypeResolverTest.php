<?php

namespace MageSuite\NotificationDashboard\Test\Integration\Model\Collector;

class TypeResolverTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\TestFramework\ObjectManager $objectManager;

    protected ?\Magento\Framework\DataObjectFactory $dataObjectFactory;

    protected function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->dataObjectFactory = $this->objectManager->get(\Magento\Framework\DataObjectFactory::class);
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
                'command' => $this->dataObjectFactory->create(),
                'sortOrder' => 10
            ],
            'too_many_items' => [
                'label' => 'Too many items',
                'command' => $this->dataObjectFactory->create(),
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
        $this->assertInstanceOf(\Magento\Framework\DataObject::class, $types['missing_data']['command']);
        $this->assertEquals('Too many items', $types['too_many_items']['label']);

        $command = $typeResolver->getCommandInstance('too_many_items');
        $this->assertInstanceOf(\Magento\Framework\DataObject::class, $command);
    }
}
