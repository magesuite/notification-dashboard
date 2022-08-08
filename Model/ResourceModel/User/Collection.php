<?php
namespace MageSuite\NotificationDashboard\Model\ResourceModel\User;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected \MageSuite\NotificationDashboard\Model\Data\UserFactory $userFactory;

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \MageSuite\NotificationDashboard\Model\Data\UserFactory $userFactory,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);

        $this->userFactory = $userFactory;
    }

    protected function _construct()
    {
        $this->_init(
            \MageSuite\NotificationDashboard\Model\Data\User::class,
            \MageSuite\NotificationDashboard\Model\ResourceModel\User::class
        );
    }
}
