<?php
namespace MageSuite\NotificationDashboard\Model\Source;

class Severity implements \Magento\Framework\Data\OptionSourceInterface
{
    const SEVERITY_CRITICAL = 'critical';
    const SEVERITY_MAJOR = 'major';
    const SEVERITY_MINOR = 'minor';
    const SEVERITY_NOTICE = 'notice';

    public static $severityTags = [
        'critical' => self::SEVERITY_CRITICAL,
        'major' =>  self::SEVERITY_MAJOR,
        'minor' => self::SEVERITY_MINOR,
        'notice' => self::SEVERITY_NOTICE
    ];

    protected ?array $options = null;

    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $this->options = [
            ['label' => '-- Please Select --', 'value' => ''],
            ['label' => 'Critical', 'value' => self::SEVERITY_CRITICAL],
            ['label' => 'Major', 'value' => self::SEVERITY_MAJOR],
            ['label' => 'Minor', 'value' => self::SEVERITY_MINOR],
            ['label' => 'Notice', 'value' => self::SEVERITY_NOTICE]
        ];

        return $this->options;
    }
}
