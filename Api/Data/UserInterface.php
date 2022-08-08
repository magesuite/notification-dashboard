<?php
namespace MageSuite\NotificationDashboard\Api\Data;

interface UserInterface
{
    const ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';
    const IS_STATIC = 'is_static';

    const CACHE_TAG = 'notification_dashboard_user';
    const EVENT_PREFIX = 'notification_dashboard_user';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return string|null
     */
    public function getName();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return int
     */
    public function getIsStatic();

    /**
     * @param int $id
     * @return self
     */
    public function setId($id);

    /**
     * @param $name
     * @return self
     */
    public function setName($name);

    /**
     * @param string|null $email
     * @return self
     */
    public function setEmail($email);

    /**
     * @param int|null $isStatic
     * @return self
     */
    public function setIsStatic($isStatic);
}
