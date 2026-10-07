<?php

declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Notification\MassAction;

abstract class AbstractMassAction extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface, \Magento\Framework\App\Action\HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        protected \Magento\Ui\Component\MassAction\Filter $filter,
        protected \MageSuite\NotificationDashboard\Model\ResourceModel\Notification\CollectionFactory $collectionFactory,
        protected \MageSuite\NotificationDashboard\Api\NotificationRepositoryInterface $notificationRepository
    ) {
        parent::__construct($context);
    }

    abstract protected function performAction(array $ids): void;

    abstract protected function getSuccessMessage(): \Magento\Framework\Phrase;

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/index');

        $notifications = $this->filter->getCollection($this->collectionFactory->create());

        try {
            $this->performAction($notifications->getAllIds());
            $this->messageManager->addSuccess($this->getSuccessMessage());
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }

        return $resultRedirect;
    }
}
