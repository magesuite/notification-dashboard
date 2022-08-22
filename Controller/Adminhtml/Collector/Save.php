<?php

namespace MageSuite\NotificationDashboard\Controller\Adminhtml\Collector;

class Save extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'MageSuite_NotificationDashboard::notification_dashboard';

    protected \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor;

    protected \Magento\Framework\Event\Manager $eventManager;

    protected \MageSuite\NotificationDashboard\Model\Data\CollectorFactory $collectorFactory;

    protected \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;

    protected \MageSuite\NotificationDashboard\Model\Command\Collector\PrepareTypeConfigurationData $prepareTypeConfigurationData;

    protected \MageSuite\NotificationDashboard\Model\Command\Collector\SaveCollectorUsers $saveCollectorUsers;

    protected \MageSuite\NotificationDashboard\Logger\Logger $logger;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Magento\Framework\Event\Manager $eventManager,
        \MageSuite\NotificationDashboard\Model\Data\CollectorFactory $collectorFactory,
        \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository,
        \MageSuite\NotificationDashboard\Model\Command\Collector\PrepareTypeConfigurationData $prepareTypeConfigurationData,
        \MageSuite\NotificationDashboard\Model\Command\Collector\SaveCollectorUsers $saveCollectorUsers,
        \MageSuite\NotificationDashboard\Logger\Logger $logger
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->eventManager = $eventManager;
        $this->collectorFactory = $collectorFactory;
        $this->collectorRepository = $collectorRepository;
        $this->prepareTypeConfigurationData = $prepareTypeConfigurationData;
        $this->saveCollectorUsers = $saveCollectorUsers;
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
            $collector = $this->collectorFactory->create();

            if ($id) {
                try {
                    $collector = $this->collectorRepository->getById($id);
                } catch (\Magento\Framework\Exception\LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This collector no longer exists.'));
                    $this->logger->warning($e->getMessage());
                    return $resultRedirect->setPath('*/*/index');
                }
            }

            $data = $this->prepareTypeConfigurationData->execute($data);
            $collector->addData($data);

            try {
                $this->collectorRepository->save($collector);

                $formData = $data['users']['users'] ?? [];
                $this->saveCollectorUsers->execute($collector->getId(), $formData);

                $this->messageManager->addSuccessMessage(__('You saved the collector.'));
                $this->dataPersistor->clear('notification_dashboard_collector');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $collector->getId()]);
                }

                return $resultRedirect->setPath('*/*/index');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->logger->warning($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the collector.'));
                $this->logger->warning($e->getMessage());
            }

            $this->dataPersistor->set('notification_dashboard_collector', $data);

            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
