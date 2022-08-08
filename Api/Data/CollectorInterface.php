<?php
namespace MageSuite\NotificationDashboard\Api\Data;

interface CollectorInterface
{
    const ID = 'id';
    const IS_ENABLED = 'is_enabled';
    const NAME = 'name';
    const TYPE = 'type';
    const SEVERITY = 'severity';
    const CRON_EXPRESSION = 'cron_expression';
    const VISIBLE_ON_DASHBOARD = 'visible_on_dashboard';
    const LIMIT_ON_DASHBOARD = 'limit_on_dashboard';
    const ADD_ADMIN_NOTIFICATION = 'add_admin_notification';
    const IS_STATIC = 'is_static';
    const CONFIGURATION = 'configuration';

    const CACHE_TAG = 'notification_dashboard_user';
    const EVENT_PREFIX = 'notification_dashboard_user';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return int|null
     */
    public function getIsEnabled();

    /**
     * @return string|null
     */
    public function getName();

    /**
     * @return string|null
     */
    public function getType();

    /**
     * @return string|null
     */
    public function getSeverity();

    /**
     * @return string|null
     */
    public function getCronExpression();

    /**
     * @return int
     */
    public function getVisibleOnDashboard();

    /**
     * @return int
     */
    public function getLimitOnDashboard();

    /**
     * @return int
     */
    public function getAddAdminNotification();

    /**
     * @return int
     */
    public function getIsStatic();

    /**
     * @return string|null
     */
    public function getConfiguration();

    /**
     * @param int $id
     * @return self
     */
    public function setId($id);

    /**
     * @param int $isEnabled
     * @return self
     */
    public function setIsEnabled(int $isEnabled);

    /**
     * @param $name
     * @return self
     */
    public function setName($name);

    /**
     * @param $type
     * @return self
     */
    public function setType($type);

    /**
     * @param $severity
     * @return self
     */
    public function setSeverity($severity);

    /**
     * @param $cronExpression
     * @return self
     */
    public function setCronExpression($cronExpression);

    /**
     * @param int|null $visibleOnDashboard
     * @return self
     */
    public function setVisibleOnDashboard($visibleOnDashboard);

    /**
     * @param int|null $limitOnDashboard
     * @return self
     */
    public function setLimitOnDashboard($limitOnDashboard);

    /**
     * @param int|null $addAdminNotification
     * @return self
     */
    public function setAddAdminNotification($addAdminNotification);

    /**
     * @param int|null $isStatic
     * @return self
     */
    public function setIsStatic($isStatic);

    /**
     * @param $configuration
     * @return self
     */
    public function setConfiguration($configuration);
}
