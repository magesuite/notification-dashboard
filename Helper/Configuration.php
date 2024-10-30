<?php

declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Helper;

class Configuration
{
    public const XML_PATH_NOTIFICATION_DASHBOARD_IS_ENABLED = 'notification_dashboard/general/is_enabled';
    public const XML_PATH_NOTIFICATION_DASHBOARD_GENERAL_EMAIL_SUBJECT_PREFIX = 'notification_dashboard/general/email_subject_prefix';
    public const XML_PATH_EMAIL_GENERAL_NAME = 'trans_email/ident_general/name';
    public const XML_PATH_EMAIL_GENERAL_EMAIL = 'trans_email/ident_general/email';

    protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface)
    {
        $this->scopeConfig = $scopeConfigInterface;
    }

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_NOTIFICATION_DASHBOARD_IS_ENABLED);
    }

    public function getEmailSenderInfo(): array
    {
        return [
            'name' => $this->scopeConfig->getValue(self::XML_PATH_EMAIL_GENERAL_NAME, \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
            'email' => $this->scopeConfig->getValue(self::XML_PATH_EMAIL_GENERAL_EMAIL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE)
        ];
    }

    public function getEmailSubjectPrefix(): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_PATH_NOTIFICATION_DASHBOARD_GENERAL_EMAIL_SUBJECT_PREFIX, \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE);
    }
}
