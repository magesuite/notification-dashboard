<?php

namespace MageSuite\NotificationDashboard\Ui\Component\Listing;

class Severity extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $severityClasses = [
        \MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_CRITICAL => 'grid-severity-critical',
        \MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_MAJOR => 'grid-severity-major',
        \MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_MINOR => 'grid-severity-minor',
        \MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_NOTICE => 'grid-severity-notice'
    ];

    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        $fieldName = $this->getData('name');

        foreach ($dataSource['data']['items'] as &$item) {
            if (!isset($item[$fieldName])) {
                continue;
            }

            $item[$fieldName] = $this->getFormattedSeverity($item[$fieldName]);
        }

        return $dataSource;
    }

    public function getFormattedSeverity($severity)
    {
        if (!isset($this->severityClasses[$severity])) {
            return __($severity);
        }

        return sprintf(
            '<span class="%s">%s</span>',
            $this->severityClasses[$severity],
            __($severity)
        );
    }
}
