<?php

namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Notification;

class MarkAsRead extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface, \Magento\Framework\App\Action\HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    protected \MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface $notificationRepository;

    protected \MageSuite\NotificationDashboard\Logger\Logger $logger;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface $notificationRepository,
        \MageSuite\NotificationDashboard\Logger\Logger $logger
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->logger = $logger;

        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $backUrl = $this->getRequest()->getParam('back_url', '*/*/index');

        $id = (int) $this->getRequest()->getParam('id');

        if (!$id) {
            $this->messageManager->addError(__('We can\'t find a notification to mark.'));
            return $resultRedirect->setPath($backUrl);
        }

        try {
            $this->notificationRepository->markAsRead([$id]);
            $this->messageManager->addSuccess(__('You marked notification as read.'));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->logger->warning($e->getMessage());
        }

        return $resultRedirect->setPath($backUrl);
    }
}
