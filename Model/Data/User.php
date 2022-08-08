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

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    public function getIsStatic()
    {
        return $this->getData(self::IS_STATIC);
    }

    public function setId($id)
    {
        $this->setData(self::ID, $id);
        return $this;
    }

    public function setName($name)
    {
        $this->setData(self::NAME, $name);
        return $this;
    }

    public function setEmail($email)
    {
        $this->setData(self::EMAIL, $email);
        return $this;
    }

    public function setIsStatic($isStatic)
    {
        $this->setData(self::IS_STATIC, $isStatic);
        return $this;
    }
}
