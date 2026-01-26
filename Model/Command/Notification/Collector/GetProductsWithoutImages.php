<?php

namespace MageSuite\NotificationDashboard\Model\Command\Notification\Collector;

class GetProductsWithoutImages extends \MageSuite\NotificationDashboard\Model\Command\Notification\CollectAndSend
{
    public function __construct(
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \MageSuite\NotificationDashboard\Model\Command\Notification\AddNotification $addNotification,
        protected \MageSuite\NotificationDashboard\Model\ResourceModel\Product $productResource
    ) {
        parent::__construct($serializer, $addNotification);
    }

    public function execute()//phpcs:ignore
    {
        $productsWithoutImages = $this->productResource->getProductsWithoutImages($this->getConfiguration());

        if (empty($productsWithoutImages)) {
            return;
        }

        $messages = [];
        foreach ($productsWithoutImages as $productWithoutImages) {
            $messages[] = __(
                "Product with sku %1 (type %2) has no images",
                $productWithoutImages['sku'],
                $productWithoutImages['type_id']
            );
        }

        $this->addNotification->execute(
            implode("<br>", $messages),
            $this->getCollector()->getId(),
            $this->getCollector()->getSeverity(),
            __('Missing product images')
        );
    }
}
