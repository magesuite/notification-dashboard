<?php

namespace MageSuite\NotificationDashboard\Service\NotificationSender\Channel;

class Email
{
    const EMAIL_TEMPLATE_IDENTIFIER = 'notification';

    protected \MageSuite\NotificationDashboard\Model\Command\Notification\AddRawDataToMessage $addRawDataToMessage;

    protected \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation;

    protected \Magento\Framework\Mail\Template\TransportBuilderFactory $transportBuilderFactory;

    protected \MageSuite\NotificationDashboard\Helper\Configuration $configuration;

    public function __construct(
        \MageSuite\NotificationDashboard\Model\Command\Notification\AddRawDataToMessage $addRawDataToMessage,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilderFactory $transportBuilderFactory,
        \MageSuite\NotificationDashboard\Helper\Configuration $configuration
    ) {
        $this->addRawDataToMessage = $addRawDataToMessage;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilderFactory = $transportBuilderFactory;
        $this->configuration = $configuration;
    }

    public function send($notification, $emails)
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
            $transport->addBcc($emails[$i]);
        }

        $transport->getTransport()->sendMessage();
        $this->inlineTranslation->resume();
    }
}