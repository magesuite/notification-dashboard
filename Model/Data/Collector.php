<?php
namespace MageSuite\NotificationDashboard\Model\Data;

class Collector extends \Magento\Framework\Model\AbstractModel implements \MageSuite\NotificationDashboard\Api\Data\CollectorInterface
{
    protected $_cacheTag = self::CACHE_TAG; //phpcs:ignore
    protected $_eventPrefix = self::EVENT_PREFIX; //phpcs:ignore

    protected function _construct()
    {
        $this->_init(\MageSuite\NotificationDashboard\Model\ResourceModel\Collector::class);
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function getIsEnabled()
    {
        return $this->getData(self::IS_ENABLED);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    public function getSeverity()
    {
        return $this->getData(self::SEVERITY);
    }

    public function getCronExpression()
    {
        return $this->getData(self::CRON_EXPRESSION);
    }

    public function getVisibleOnDashboard()
    {
        return $this->getData(self::VISIBLE_ON_DASHBOARD);
    }

    public function getLimitOnDashboard()
    {
        return $this->getData(self::LIMIT_ON_DASHBOARD);
    }

    public function getAddAdminNotification()
    {
        return $this->getData(self::ADD_ADMIN_NOTIFICATION);
    }

    public function getIsStatic()
    {
        return $this->getData(self::IS_STATIC);
    }

    public function getConfiguration()
    {
        return $this->getData(self::CONFIGURATION);
    }

    public function setId($id)
    {
        $this->setData(self::ID, $id);
        return $this;
    }

    public function setIsEnabled($isEnabled)
    {
        $this->setData(self::IS_STATIC, $isEnabled);
        return $this;
    }

    public function setName($name)
    {
        $this->setData(self::NAME, $name);
        return $this;
    }

    public function setType($type)
    {
        $this->setData(self::TYPE, $type);
        return $this;
    }

    public function setSeverity($severity)
    {
        $this->setData(self::SEVERITY, $severity);
        return $this;
    }

    public function setCronExpression($cronExpression)
    {
        $this->setData(self::CRON_EXPRESSION, $cronExpression);
        return $this;
    }

    public function setVisibleOnDashboard($visibleOnDashboard)
    {
        $this->setData(self::VISIBLE_ON_DASHBOARD, $visibleOnDashboard);
        return $this;
    }

    public function setLimitOnDashboard($limitOnDashboard)
    {
        $this->setData(self::LIMIT_ON_DASHBOARD, $limitOnDashboard);
        return $this;
    }

    public function setAddAdminNotification($addAdminNotification)
    {
        $this->setData(self::ADD_ADMIN_NOTIFICATION, $addAdminNotification);
        return $this;
    }

    public function setIsStatic($isStatic)
    {
        $this->setData(self::IS_STATIC, $isStatic);
        return $this;
    }

    public function setConfiguration($configuration)
    {
        $this->setData(self::CONFIGURATION, $configuration);
        return $this;
    }
}
