<?php

namespace MageSuite\NotificationDashboard\Model\Command\Notification\Collector;

class GetOrdersWithNotPaidInvoices extends \MageSuite\NotificationDashboard\Model\Command\Notification\CollectAndSend
{
    protected \MageSuite\NotificationDashboard\Model\ResourceModel\Order $orderResource;

    protected \Magento\Framework\Stdlib\DateTime\Timezone $timezone;

    public function __construct(
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification,
        \MageSuite\NotificationDashboard\Model\ResourceModel\Order $orderResource,
        \Magento\Framework\Stdlib\DateTime\Timezone $timezone
    ) {
        parent::__construct($serializer, $addNotification);

        $this->orderResource = $orderResource;
        $this->timezone = $timezone;
    }

    public function execute()
    {
        $configuration = $this->getConfiguration();

        $maxDate = (new \DateTime())
            ->modify(sprintf('-%s days', $configuration['time_delay']))
            ->format('Y-m-d 23:59:59');

        $minDate = (new \DateTime())
            ->modify(sprintf('-%s days', ($configuration['time_delay'] + $configuration['time_period'])))
            ->format('Y-m-d 00:00:00');

        $ordersInfo = $this->orderResource->getOrdersWithNotPaidInvoice($maxDate, $minDate);

        if (empty($ordersInfo)) {
            return;
        }

        foreach ($ordersInfo as $orderInfo) {
            $this->addNotification->execute(
                __(
                    "Order #%1 has still open invoice and it was created at %2.",
                    $orderInfo['increment_id'],
                    $this->timezone
                        ->date(new \DateTime($orderInfo['invoice_created_at']))
                        ->format(\Magento\Framework\Stdlib\DateTime::DATETIME_PHP_FORMAT)
                ),
                $this->getCollector()->getId(),
                $this->getCollector()->getSeverity(),
                __('Order with open invoice')
            );
        }
    }
}
