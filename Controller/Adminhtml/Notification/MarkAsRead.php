<?php
namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Notification;

class MarkAsRead extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface, \Magento\Framework\App\Action\HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    protected \MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface $notificationRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface $notificationRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $backUrl = $this->getRequest()->getParam('back_url', '*/*/index');

        $id = (int) $this->getRequest()->getParam('id');

        if ($id) {
            try {
                $this->notificationRepository->markAsRead([$id]);
                $this->messageManager->addSuccess(__('You marked notification as read.'));

                return $resultRedirect->setPath($backUrl);
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());

                return $resultRedirect->setPath($backUrl);
            }
        }

        $this->messageManager->addError(__('We can\'t find a notification to mark.'));

        return $resultRedirect->setPath($backUrl);
    }
}
