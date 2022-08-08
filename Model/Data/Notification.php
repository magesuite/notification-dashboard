<?php
namespace MageSuite\NotificationDashboard\Model\Data;

class Notification extends \Magento\Framework\Model\AbstractModel implements \MageSuite\NotificationDashboard\Api\Data\NotificationInterface
{
    protected $_cacheTag = self::CACHE_TAG; //phpcs:ignore
    protected $_eventPrefix = self::EVENT_PREFIX; //phpcs:ignore

    protected function _construct()
    {
        $this->_init(\MageSuite\NotificationDashboard\Model\ResourceModel\Notification::class);
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function getCollectorId()
    {
        return $this->getData(self::COLLECTOR_ID);
    }

    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    public function getSeverity()
    {
        return $this->getData(self::SEVERITY);
    }

    public function getIsRead()
    {
        return $this->getData(self::IS_READ);
    }

    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
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

    public function setTitle($title)
    {
        $this->setData(self::TITLE, $title);
        return $this;
    }

    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    public function setSeverity($severity)
    {
        return $this->setData(self::SEVERITY, $severity);
    }

    public function setIsRead($isRead)
    {
        return $this->setData(self::IS_READ, $isRead);
    }

    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
