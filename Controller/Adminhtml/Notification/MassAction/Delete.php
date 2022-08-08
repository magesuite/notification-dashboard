<?php

namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Notification\MassAction;

class Delete extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface, \Magento\Framework\App\Action\HttpPostActionInterface
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

        $this->notificationRepository->deletebyIds($notifications->getAllIds());
        return $resultRedirect;
    }
}
