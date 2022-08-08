<?php

namespace MageSuite\NotificationDashboard\Block\Adminhtml\Dashboard\Notification\Column\Renderer;

class Severity extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected \MageSuite\NotificationDashboard\Ui\Component\Listing\Severity $severityComponentListing;

    public function __construct(
        \Magento\Backend\Block\Context $context,
        \MageSuite\NotificationDashboard\Ui\Component\Listing\Severity $severityComponentListing,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->severityComponentListing = $severityComponentListing;
    }

    public function render(\Magento\Framework\DataObject $row)
    {
        return $this->severityComponentListing->getFormattedSeverity($row->getSeverity());
    }
}
