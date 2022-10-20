<?php

namespace MageSuite\NotificationDashboard\Model\Command\Notification\Collector;

class GetAvailablePaymentMethods extends \MageSuite\NotificationDashboard\Model\Command\Notification\CollectAndSend
{
    protected \Magento\Store\Model\StoreManagerInterface $storeManager;

    protected \Magento\Payment\Api\PaymentMethodListInterface $paymentMethodList;

    public function __construct(
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Payment\Api\PaymentMethodListInterface $paymentMethodList
    ) {
        parent::__construct($serializer, $addNotification);

        $this->storeManager = $storeManager;
        $this->paymentMethodList = $paymentMethodList;
    }

    public function execute()
    {
        foreach ($this->storeManager->getStores() as $store) {
            if (!$store->getIsActive()) {
                continue;
            }

            $availableMethods = $this->paymentMethodList->getActiveList($store->getId());

            if (!empty($availableMethods)) {
                continue;
            }

            $this->addNotification->execute(
                __(
                    "Missing payment methods in %1 store",
                    $store->getName()
                ),
                $this->getCollector()->getId(),
                $this->getCollector()->getSeverity(),
                __('Missing payment methods')
            );
        }
    }
}
