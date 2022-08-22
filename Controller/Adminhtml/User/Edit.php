<?php

namespace MageSuite\NotificationDashboard\Controller\Adminhtml\User;

class Edit extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    protected \Magento\Framework\View\Result\PageFactory $resultPageFactory;

    protected \MageSuite\NotificationDashboard\Api\UserRepositoryInterface $userRepository;

    protected \Magento\Framework\Registry $registry;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \MageSuite\NotificationDashboard\Api\UserRepositoryInterface $userRepository,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->userRepository = $userRepository;
        $this->registry = $registry;

        parent::__construct($context);
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');

        $title = __('New User');

        if ($id) {
            $user = $this->userRepository->getById($id);

            if (!$user->getId()) {
                $this->messageManager->addErrorMessage(__('This user no longer exists.'));

                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }

            $this->registry->register('current_entity', $user);
            $title = __('Edit User %1', $user->getName());
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->addBreadcrumb($title, $title);
        $resultPage->getConfig()->getTitle()->prepend(__('Users'));
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
