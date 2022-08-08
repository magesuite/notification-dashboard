<?php
namespace MageSuite\NotificationDashboard\Api\Data;

interface NotificationInterface
{
    const ID = 'id';
    const COLLECTOR_ID = 'collector_id';
    const TITLE = 'title';
    const MESSAGE = 'message';
    const SEVERITY = 'severity';
    const IS_READ = 'is_read';
    const CREATED_AT = 'created_at';

    const CACHE_TAG = 'notification_dashboard_notification';
    const EVENT_PREFIX = 'notification_dashboard_notification';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return int|null
     */
    public function getCollectorId();

    /**
     * @return string|null
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return string|null
     */
    public function getSeverity();

    /**
     * @return int|null
     */
    public function getIsRead();

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param int $id
     * @return self
     */
    public function setId($id);

    /**
     * @param int $collectorId
     * @return self
     */
    public function setCollectorId($collectorId);

    /**
     * @param $title
     * @return self
     */
    public function setTitle($title);

    /**
     * @param string|null $message
     * @return self
     */
    public function setMessage($message);

    /**
     * @param $severity
     * @return self
     */
    public function setSeverity($severity);

    /**
     * @param $isRead
     * @return self
     */
    public function setIsRead($isRead);

    /**
     * @param string|null $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt);
}
