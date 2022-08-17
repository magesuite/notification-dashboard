<?php

namespace MageSuite\NotificationDashboard\Model\Collector;

class TypeResolver
{
    protected array $collectorTypes = [];

    public function __construct(array $collectorTypes)
    {
        $this->collectorTypes = $collectorTypes;
    }

    public function getCollectorTypes()
    {
        return $this->collectorTypes;
    }

    public function getProcessorInstance($type)
    {
        if (!$type) {
            return null;
        }

        foreach ($this->collectorTypes as $collectorType => $collector) {
            if ($collectorType != $type) {
                continue;
            }

            return $collector['processor'];
        }

        return null;
    }
}
