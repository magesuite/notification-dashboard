<?php

declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Block\Adminhtml;

class Dashboard extends \Magento\Backend\Block\Template
{
    protected const string HEADER_NAME_FORMAT = '<h2 style="margin-bottom: 0px;"><a href="%s">%s</a></h2>';

    protected \MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->collectorRepository = $collectorRepository;
    }

    public function getNotificationGridHtml(): string
    {
        $gridHtml = [];

        $collectors = $this->collectorRepository->getCollectorsVisibleOnDashboard();

        foreach ($collectors as $collector) {
            $gridHtml[] = sprintf(
                self::HEADER_NAME_FORMAT,
                $this->getUrl('*/notification/index', ['_query' => ['collector_id' => $collector->getId()]]),
                $this->escapeHtml($collector->getName())
            );

            $gridHtml[] = $this
                ->getLayout()
                ->createBlock(
                    \MageSuite\NotificationDashboard\Block\Adminhtml\Dashboard\Notification::class,
                    sprintf('notification.dashboard.collector%s', $collector->getId())
                )
                ->setCollectorId($collector->getId())
                ->setLimit($collector->getLimitOnDashboard())
                ->toHtml();
        }

        return implode(PHP_EOL, $gridHtml);
    }
}
