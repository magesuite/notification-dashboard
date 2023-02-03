<?php

namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Collector;

class CleanAdditionalData extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    protected \Magento\Framework\View\Result\PageFactory $resultPageFactory;

    protected \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository,
    ) {
        $this->collectorRepository = $collectorRepository;

        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = (int)$this->getRequest()->getParam('id');

        if ($id) {
            return $resultRedirect->setPath('*/*/');
        }

        $collector = $this->collectorRepository->getById($id);

        if (!$collector->getId()) {
            $this->messageManager->addErrorMessage(__('This collector no longer exists.'));

            /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }

        $collector->setAdditionalData(null);
        $this->collectorRepository->save($collector);

        return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
    }
}
