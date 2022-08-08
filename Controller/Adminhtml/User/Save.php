<?php
namespace MageSuite\NotificationDashboard\Controller\Adminhtml\User;

class Save extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    protected \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor;

    protected \Magento\Framework\Event\Manager $eventManager;

    protected \MageSuite\NotificationDashboard\Model\Data\UserFactory $userFactory;

    protected \MageSuite\NotificationDashboard\Api\UserRepositoryInterface $userRepository;

    protected \MageSuite\NotificationDashboard\Logger\Logger $logger;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\Event\Manager $eventManager,
        \MageSuite\NotificationDashboard\Model\Data\UserFactory $userFactory,
        \MageSuite\NotificationDashboard\Api\UserRepositoryInterface $userRepository,
        \MageSuite\NotificationDashboard\Logger\Logger $logger
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->eventManager = $eventManager;
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
        $this->logger = $logger;

        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue('general');

        if ($data) {
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            $id = (int)$this->getRequest()->getParam('id');
            $user = $this->userFactory->create();

            if ($id) {
                try {
                    $user = $this->userRepository->getById($id);
                } catch (\Magento\Framework\Exception\LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This user no longer exists.'));
                    return $resultRedirect->setPath('*/*/index');
                }
            }

            $user->addData($data);

            try {
                $this->userRepository->save($user);

                $this->messageManager->addSuccessMessage(__('You saved the user.'));
                $this->dataPersistor->clear('notification_dashboard_user');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $user->getId()]);
                }

                return $resultRedirect->setPath('*/*/index');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the user.'));
            }

            $this->dataPersistor->set('notification_dashboard_user', $data);

            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
