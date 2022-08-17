<?php

namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Collector;

class Edit extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    protected \Magento\Framework\View\Result\PageFactory $resultPageFactory;

    protected \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;

    protected \Magento\Framework\Registry $registry;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->collectorRepository = $collectorRepository;
        $this->registry = $registry;

        parent::__construct($context);
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');

        $title = __('New Collector');

        if ($id) {
            $collector = $this->collectorRepository->getById($id);

            if (!$collector->getId()) {
                $this->messageManager->addErrorMessage(__('This collector no longer exists.'));

                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }

            $this->registry->register('current_entity', $collector);
            $title = __('Edit Collector %1', $collector->getName());
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->addBreadcrumb($title, $title);
        $resultPage->getConfig()->getTitle()->prepend(__('Collectors'));
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
