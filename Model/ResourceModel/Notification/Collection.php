<?php
namespace MageSuite\NotificationDashboard\Model\ResourceModel\Notification;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \MageSuite\NotificationDashboard\Model\Data\Notification::class,
            \MageSuite\NotificationDashboard\Model\ResourceModel\Notification::class
        );
    }

    public function addFieldToFilter($field, $condition = null)
    {
        if (is_array($field) && $field[0] == 'fulltext') {
            return parent::addFieldToFilter(
                ['title', 'message'],
                [
                    ['attribute' => 'title', 'like' => $condition[0]['like']],
                    ['attribute' => 'message', 'like' => $condition[0]['like']]
                ]
            );
        }

        return parent::addFieldToFilter($field, $condition);
    }
}
