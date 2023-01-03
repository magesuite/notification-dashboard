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

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function getIsEnabled()
    {
        return $this->getData(self::IS_ENABLED);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @inheritDoc
     */
    public function getSeverity()
    {
        return $this->getData(self::SEVERITY);
    }

    /**
     * @inheritDoc
     */
    public function getCronExpression()
    {
        return $this->getData(self::CRON_EXPRESSION);
    }

    /**
     * @inheritDoc
     */
    public function getVisibleOnDashboard()
    {
        return $this->getData(self::VISIBLE_ON_DASHBOARD);
    }

    /**
     * @inheritDoc
     */
    public function getLimitOnDashboard()
    {
        return $this->getData(self::LIMIT_ON_DASHBOARD);
    }

    /**
     * @inheritDoc
     */
    public function getAddAdminNotification()
    {
        return $this->getData(self::ADD_ADMIN_NOTIFICATION);
    }

    /**
     * @inheritDoc
     */
    public function getIsStatic()
    {
        return $this->getData(self::IS_STATIC);
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration()
    {
        return $this->getData(self::CONFIGURATION);
    }

    /**
     * @inheritDoc
     */
    public function getAdditionalData()
    {
        return $this->getData(self::ADDITIONAL_DATA);
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
        $this->setData(self::ID, $id);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setIsEnabled($isEnabled)
    {
        $this->setData(self::IS_STATIC, $isEnabled);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        $this->setData(self::NAME, $name);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setType($type)
    {
        $this->setData(self::TYPE, $type);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setSeverity($severity)
    {
        $this->setData(self::SEVERITY, $severity);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setCronExpression($cronExpression)
    {
        $this->setData(self::CRON_EXPRESSION, $cronExpression);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setVisibleOnDashboard($visibleOnDashboard)
    {
        $this->setData(self::VISIBLE_ON_DASHBOARD, $visibleOnDashboard);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setLimitOnDashboard($limitOnDashboard)
    {
        $this->setData(self::LIMIT_ON_DASHBOARD, $limitOnDashboard);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setAddAdminNotification($addAdminNotification)
    {
        $this->setData(self::ADD_ADMIN_NOTIFICATION, $addAdminNotification);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setIsStatic($isStatic)
    {
        $this->setData(self::IS_STATIC, $isStatic);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setConfiguration($configuration)
    {
        $this->setData(self::CONFIGURATION, $configuration);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setAdditionalData($additionalData)
    {
        $this->setData(self::ADDITIONAL_DATA, $additionalData);
        return $this;
    }
}
