<?php

namespace MageSuite\NotificationDashboard\Model\Data;

class CollectorUser extends \Magento\Framework\Model\AbstractModel
{
    const ID = 'id';
    const COLLECTOR_ID = 'collector_id';
    const USER_ID = 'user_id';
    const SEND_EMAIL = 'send_email';

    const CACHE_TAG = 'notification_dashboard_notification';
    const EVENT_PREFIX = 'notification_dashboard_notification';

    protected $_cacheTag = self::CACHE_TAG; //phpcs:ignore
    protected $_eventPrefix = self::EVENT_PREFIX; //phpcs:ignore

    protected function _construct()
    {
        $this->_init(\MageSuite\NotificationDashboard\Model\ResourceModel\CollectorUser::class);
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function getCollectorId()
    {
        return $this->getData(self::COLLECTOR_ID);
    }

    public function getUserId()
    {
        return $this->getData(self::USER_ID);
    }

    public function getSendEmail()
    {
        return $this->getData(self::SEND_EMAIL);
    }

    public function setId($id)
    {
        $this->setData(self::ID, $id);
        return $this;
    }

    public function setCollectorId($collectorId)
    {
        $this->setData(self::COLLECTOR_ID, $collectorId);
        return $this;
    }

    public function setUserId($userId)
    {
        $this->setData(self::USER_ID, $userId);
        return $this;
    }

    public function setSendEmail($sendEmail)
    {
        $this->setData(self::SEND_EMAIL, $sendEmail);
        return $this;
    }
}
