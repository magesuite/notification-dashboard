<?php

namespace MageSuite\NotificationDashboard\Helper;

class Configuration
{
    const XML_PATH_EMAIL_GENERAL_NAME = 'trans_email/ident_general/name';
    const XML_PATH_EMAIL_GENERAL_EMAIL = 'trans_email/ident_general/email';

    protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface)
    {
        $this->scopeConfig = $scopeConfigInterface;
    }

    public function getEmailSenderInfo()
    {
        return [
            'name' => $this->scopeConfig->getValue(self::XML_PATH_EMAIL_GENERAL_NAME, \Magento\Store\Model\ScopeInterface::SCOPE_STORE),
            'email' => $this->scopeConfig->getValue(self::XML_PATH_EMAIL_GENERAL_EMAIL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE)
        ];
    }
}
