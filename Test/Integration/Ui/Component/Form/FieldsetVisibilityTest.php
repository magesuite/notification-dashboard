<?php

namespace MageSuite\NotificationDashboard\Test\Integration\Ui\Component\Form;

class FieldsetVisibilityTest extends \PHPUnit\Framework\TestCase
{
    protected ?\MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository;

    protected ?\MageSuite\NotificationDashboard\Model\UserRepository $userRepository;

    protected ?\Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder;

    protected ?\Magento\Framework\Registry $registry;

    protected ?\MageSuite\NotificationDashboard\Ui\Component\Form\FieldsetVisibility $fieldsetVisibility;

    protected function setUp(): void
    {
        $objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->collectorRepository = $objectManager->get(\MageSuite\NotificationDashboard\Model\CollectorRepository::class);
        $this->userRepository = $objectManager->get(\MageSuite\NotificationDashboard\Model\UserRepository::class);
        $this->searchCriteriaBuilder = $objectManager->get(\Magento\Framework\Api\SearchCriteriaBuilder::class);
        $this->registry = $objectManager->get(\Magento\Framework\Registry::class);
        $this->fieldsetVisibility = $objectManager->get(\MageSuite\NotificationDashboard\Ui\Component\Form\FieldsetVisibility::class);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoDataFixture MageSuite_NotificationDashboard::Test/Integration/_files/collector.php
     * @magentoDataFixture MageSuite_NotificationDashboard::Test/Integration/_files/user.php
     */
    public function testItSetDisabledFlagForStaticEntities()
    {
        $this->registerEntity('user');
        $config = $this->fieldsetVisibility->getConfiguration();
        $this->assertArrayNotHasKey('disabled', $config);

        $this->registerEntity('user', true);
        $config = $this->fieldsetVisibility->getConfiguration();
        $this->assertTrue($config['disabled']);

        $this->registerEntity('collector');
        $config = $this->fieldsetVisibility->getConfiguration();
        $this->assertArrayNotHasKey('disabled', $config);

        $this->registerEntity('collector', true);
        $config = $this->fieldsetVisibility->getConfiguration();
        $this->assertTrue($config['disabled']);
    }

    /**
     * @magentoAppIsolation enabled
     * @magentoDbIsolation enabled
     * @magentoDataFixture MageSuite_NotificationDashboard::Test/Integration/_files/collector.php
     * @magentoDataFixture MageSuite_NotificationDashboard::Test/Integration/_files/user.php
     */
    public function testItReturnsCorrectVisibilityFlag()
    {
        $collector = $this->registerEntity('collector');

        $this->fieldsetVisibility->setData('name', 'unique_value');
        $this->assertFalse($this->fieldsetVisibility->isComponentVisible());

        $this->fieldsetVisibility->setData('name', $collector->getType());
        $this->assertTrue($this->fieldsetVisibility->isComponentVisible());
    }

    protected function registerEntity($type, $isStatic = false)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(\MageSuite\NotificationDashboard\Api\Data\CollectorInterface::IS_STATIC, $isStatic)
            ->create();

        if ($type == 'user') {
            $list = $this->userRepository->getList($searchCriteria);
        } elseif ($type == 'collector') {
            $list = $this->collectorRepository->getList($searchCriteria);
        }

        $items = $list->getItems();

        if ($this->registry->registry('current_entity')) {
            $this->registry->unregister('current_entity');
        }

        $items = $list->getItems();
        $entity = array_shift($items);

        $this->registry->register('current_entity', $entity);
        return $entity;
    }
}
