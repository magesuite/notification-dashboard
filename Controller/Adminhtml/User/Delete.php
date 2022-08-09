<?php
namespace MageSuite\NotificationDashboard\Controller\Adminhtml\User;

class Delete extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface, \Magento\Framework\App\Action\HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    protected \MageSuite\NotificationDashboard\Api\UserRepositoryInterface $userRepository;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MageSuite\NotificationDashboard\Api\UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int) $this->getRequest()->getParam('id');

        if (!$id) {
            $this->messageManager->addError(__('We can\'t find a user to delete.'));
            return $resultRedirect->setPath('*/*/index');
        }

        try {
            $this->userRepository->deleteById($id);
            $this->messageManager->addSuccess(__('You deleted the user.'));

            return $resultRedirect->setPath('*/*/index');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());

            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
    }
}
