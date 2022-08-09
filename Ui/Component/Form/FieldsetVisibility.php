<?php
declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Ui\Component\Form;

class FieldsetVisibility extends \Magento\Ui\Component\Form\Fieldset implements \Magento\Framework\View\Element\ComponentVisibilityInterface
{
    const GENERAL_FIELDSET_NAME = 'general';

    protected \Magento\Framework\Registry $registry;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\Registry $registry,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $components, $data);

        $this->registry = $registry;
    }

    public function getConfiguration()
    {
        $config = (array)$this->getData('config');

        $currentEntity = $this->getCurrentEntity();

        if (!$currentEntity || !$currentEntity->getIsStatic()) {
            return $config;
        }

        $config['disabled'] = true;
        return $config;
    }

    public function isComponentVisible(): bool
    {
        if ($this->getName() == self::GENERAL_FIELDSET_NAME) {
            return true;
        }

        $currentEntity = $this->getCurrentEntity();

        if ($currentEntity === null) {
            return false;
        }

        if (!$currentEntity instanceof \MageSuite\NotificationDashboard\Model\Data\Collector) {
            return true;
        }

        return $this->getName() == $currentEntity->getType();
    }

    protected function getCollectorType()
    {
        $currentCollector = $this->registry->registry('current_entity');

        if (empty($currentCollector)) {
            return null;
        }

        return $currentCollector->getType();
    }

    protected function getCurrentEntity()
    {
        return $this->registry->registry('current_entity');
    }
}
