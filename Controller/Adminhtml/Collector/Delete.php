<?php
namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Collector;

class Delete extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface, \Magento\Framework\App\Action\HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    protected \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository
    ) {
        $this->collectorRepository = $collectorRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int) $this->getRequest()->getParam('id');

        if ($id) {
            try {
                $this->collectorRepository->deleteById($id);
                $this->messageManager->addSuccess(__('You deleted the collector.'));

                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addError(__('We can\'t find a collector to delete.'));

        return $resultRedirect->setPath('*/*/index');
    }
}
