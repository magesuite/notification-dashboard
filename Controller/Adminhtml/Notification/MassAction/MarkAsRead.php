<?php

namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Notification\MassAction;

class MarkAsRead extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface, \Magento\Framework\App\Action\HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    protected \Magento\Ui\Component\MassAction\Filter $filter;

    protected \MageSuite\NotificationDashboard\Model\ResourceModel\Notification\CollectionFactory $collectionFactory;

    protected \MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface $notificationRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \MageSuite\NotificationDashboard\Model\ResourceModel\Notification\CollectionFactory $collectionFactory,
        \MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface $notificationRepository
    ) {
        parent::__construct($context);

        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->notificationRepository = $notificationRepository;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/index');

        $notifications = $this->filter->getCollection($this->collectionFactory->create());

        try {
            $this->notificationRepository->markAsRead($notifications->getAllIds());
            $this->messageManager->addSuccess(__('You marked notifications as read.'));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }

        return $resultRedirect;
    }
}
