<?php

namespace MageSuite\NotificationDashboard\Model\Data;

class User extends \Magento\Framework\Model\AbstractModel implements \MageSuite\NotificationDashboard\Api\Data\UserInterface
{
    protected $_cacheTag = self::CACHE_TAG; //phpcs:ignore
    protected $_eventPrefix = self::EVENT_PREFIX; //phpcs:ignore

    protected function _construct()
    {
        $this->_init(\MageSuite\NotificationDashboard\Model\ResourceModel\User::class);
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
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
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
    public function setId($id)
    {
        $this->setData(self::ID, $id);
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
    public function setEmail($email)
    {
        $this->setData(self::EMAIL, $email);
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
}
