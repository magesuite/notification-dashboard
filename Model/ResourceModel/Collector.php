<?php

namespace MageSuite\NotificationDashboard\Model\ResourceModel;

class Collector extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('notification_dashboard_collector', \MageSuite\NotificationDashboard\Api\Data\CollectorInterface::ID);
    }

    public function delete(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->getIsStatic()) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__('The collector with the "%1" name can\'t be deleted.', $object->getName()));
        }

        return parent::delete($object);
    }
}
