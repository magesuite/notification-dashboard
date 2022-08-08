<?php

namespace MageSuite\NotificationDashboard\Service\Notification\Channel;

class Email
{
    const EMAIL_TEMPLATE_IDENTIFIER = 'notification';

    protected \MageSuite\NotificationDashboard\Model\Command\Notification\AddRawDataToMessage $addRawDataToMessage;

    protected \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation;

    protected \Magento\Framework\Mail\Template\TransportBuilderFactory $transportBuilderFactory;

    protected \MageSuite\NotificationDashboard\Helper\Configuration $configuration;

    protected \MageSuite\NotificationDashboard\Logger\Logger $logger;

    public function __construct(
        \MageSuite\NotificationDashboard\Model\Command\Notification\AddRawDataToMessage $addRawDataToMessage,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilderFactory $transportBuilderFactory,
        \MageSuite\NotificationDashboard\Helper\Configuration $configuration,
        \MageSuite\NotificationDashboard\Logger\Logger $logger
    ) {
        $this->addRawDataToMessage = $addRawDataToMessage;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilderFactory = $transportBuilderFactory;
        $this->configuration = $configuration;
        $this->logger = $logger;
    }

    public function execute($notification, $emails)
    {
        $this->inlineTranslation->suspend();

        $message = $this->addRawDataToMessage->execute($notification);

        $transport = $this->transportBuilderFactory
            ->create()
            ->setTemplateIdentifier(self::EMAIL_TEMPLATE_IDENTIFIER)
            ->setTemplateOptions(['area' => 'adminhtml', 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID])
            ->setTemplateVars(['message' => $message, 'title' => (string)$notification->getTitle()])
            ->setFromByScope($this->configuration->getEmailSenderInfo())
            ->addTo($emails[0]);

        $count = count($emails);
        for ($i = 1; $i < $count; $i++) {
            $transport->addCc($emails[$i]);
        }

        $transport->getTransport()->sendMessage();
        $this->inlineTranslation->resume();

        $this->logger->error($message);
    }
}
