<?php

namespace MageSuite\NotificationDashboard\Service\NotificationSender\Channel;

class Email
{
    public const EMAIL_TEMPLATE_IDENTIFIER = 'notification';

    protected \MageSuite\NotificationDashboard\Model\Command\Notification\AddRawDataToMessage $addRawDataToMessage;
    protected \MageSuite\NotificationDashboard\Helper\Configuration $configuration;
    protected \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation;
    protected \Magento\Framework\Mail\Template\TransportBuilderFactory $transportBuilderFactory;

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

    public function send(\MageSuite\NotificationDashboard\Api\Data\NotificationInterface $notification, array $channelsData): void
    {
        $this->inlineTranslation->suspend();

        $emailSubject = $this->getEmailTitle($notification);
        $emailContent = $this->getEmailContent($notification);

        $transport = $this->transportBuilderFactory
            ->create()
            ->setTemplateIdentifier(self::EMAIL_TEMPLATE_IDENTIFIER)
            ->setTemplateOptions(['area' => 'adminhtml', 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID])
            ->setTemplateVars(['message' => $emailContent, 'title' => $emailSubject])
            ->setFromByScope($this->configuration->getEmailSenderInfo())
            ->addTo($channelsData[0]->getChannel());

        $count = count($channelsData);
        for ($i = 1; $i < $count; $i++) {
            $transport->addBcc($channelsData[$i]->getChannel());
        }

        $transport->getTransport()->sendMessage();
        $this->inlineTranslation->resume();
    }

    protected function getEmailTitle(\MageSuite\NotificationDashboard\Api\Data\NotificationInterface $notification): string
    {
        $subjectPrefix = $this->configuration->getEmailSubjectPrefix();
        $notificationTitle = (string)$notification->getTitle();

        return sprintf('%s%s', $subjectPrefix, $notificationTitle);
    }

    protected function getEmailContent(\MageSuite\NotificationDashboard\Api\Data\NotificationInterface $notification): string
    {
        return (string)$this->addRawDataToMessage->execute($notification);
    }
}
