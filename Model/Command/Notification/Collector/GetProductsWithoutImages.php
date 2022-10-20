<?php

namespace MageSuite\NotificationDashboard\Model\Command\Notification\Collector;

class GetProductsWithoutImages extends \MageSuite\NotificationDashboard\Model\Command\Notification\CollectAndSend
{
    protected \MageSuite\NotificationDashboard\Model\ResourceModel\Product $productResource;

    public function __construct(
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification,
        \MageSuite\NotificationDashboard\Model\ResourceModel\Product $productResource
    ) {
        parent::__construct($serializer, $addNotification);

        $this->productResource = $productResource;
    }

    public function execute()
    {
        $configuration = $this->getConfiguration();

        $typeIds = $configuration['type_ids'] ?? [];
        $productWithoutImages = $this->productResource->getProductsWithoutImages($typeIds);

        if (empty($productWithoutImages)) {
            return;
        }

        $excludedSkus = [];

        if (!empty($configuration['excluded_skus'])) {
            $excludedSkus = explode(',', $configuration['excluded_skus']);
            $excludedSkus = array_map('trim', $excludedSkus);
            $excludedSkus = array_flip($excludedSkus);
        }

        foreach ($productWithoutImages as $productWithoutImages) {
            if (isset($excludedSkus[$productWithoutImages['sku']])) {
                continue;
            }

            $this->addNotification->execute(
                __(
                    "Product with sku %1 (type %2) has no images",
                    $productWithoutImages['sku'],
                    $productWithoutImages['type_id']
                ),
                $this->getCollector()->getId(),
                $this->getCollector()->getSeverity(),
                __('Missing product images')
            );
        }

        $a = 1;
    }
}
