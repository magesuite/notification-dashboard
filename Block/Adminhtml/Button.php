<?php

namespace MageSuite\NotificationDashboard\Block\Adminhtml;

class Button
{
    protected \Magento\Framework\App\RequestInterface $request;

    protected \Magento\Framework\Registry $registry;

    protected \Magento\Framework\UrlInterface $urlBuilder;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->request = $request;
        $this->registry = $registry;
        $this->urlBuilder = $urlBuilder;
    }

    protected function isStatic()
    {
        $currentEntity = $this->registry->registry('current_entity');

        if ($currentEntity && $currentEntity->getIsStatic()) {
            return true;
        }

        return false;
    }
}
