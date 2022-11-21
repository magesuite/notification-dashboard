<?php
declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Model\Collector;

class TypeResolver
{
    protected array $collectorTypes;

    public function __construct(array $collectorTypes = [])
    {
        uasort($collectorTypes, [$this, 'compareTypesSortOrder']);
        $this->collectorTypes = $collectorTypes;
    }

    public function getCollectorTypes(): array
    {
        return $this->collectorTypes;
    }

    /**
     * @param string $type
     * @return object
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCommandInstance(string $type): object
    {
        foreach ($this->collectorTypes as $collectorType => $collector) {
            if ($collectorType != $type || !isset($collector['command']) || !is_object($collector['command'])) {
                continue;
            }

            return $collector['command'];
        }

        throw new \Magento\Framework\Exception\LocalizedException(
            __('The command instance is not defined for collector with ID: %1.', $collectorId)
        );
    }

    protected function compareTypesSortOrder($typeDataFirst, $typeDataSecond): int
    {
        return (int)$typeDataFirst['sortOrder'] <=> (int)$typeDataSecond['sortOrder'];
    }
}
