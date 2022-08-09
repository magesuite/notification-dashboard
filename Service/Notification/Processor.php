<?php
namespace MageSuite\NotificationDashboard\Service\Notification;

class Processor
{
    protected \MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository;

    protected \MageSuite\NotificationDashboard\Model\UserRepository $userRepository;

    protected \MageSuite\NotificationDashboard\Model\CollectorUserRepository $collectorUserRepository;

    protected \MageSuite\NotificationDashboard\Service\Notification\Channel\Admin $adminChannel;

    protected \MageSuite\NotificationDashboard\Service\Notification\Channel\Resolver $notificationChannelResolver;

    protected \MageSuite\NotificationDashboard\Logger\Logger $logger;

    public function __construct(
        \MageSuite\NotificationDashboard\Model\CollectorRepository $collectorRepository,
        \MageSuite\NotificationDashboard\Model\UserRepository $userRepository,
        \MageSuite\NotificationDashboard\Model\CollectorUserRepository $collectorUserRepository,
        \MageSuite\NotificationDashboard\Service\Notification\Channel\Admin $adminChannel,
        \MageSuite\NotificationDashboard\Service\Notification\Channel\Resolver $notificationChannelResolver,
        \MageSuite\NotificationDashboard\Logger\Logger $logger
    ) {
        $this->collectorRepository = $collectorRepository;
        $this->userRepository = $userRepository;
        $this->collectorUserRepository = $collectorUserRepository;
        $this->adminChannel = $adminChannel;
        $this->notificationChannelResolver = $notificationChannelResolver;
        $this->logger = $logger;
    }

    public function execute($notifications)
    {
        $notificationChannels = $this->notificationChannelResolver->getAllChannels();

        list($collectors, $channelsData) = $this->getCollectorsAndChannelsData($notifications);

        foreach ($notifications as $notification) {
            $collectorId = $notification->getCollectorId();
            $collector = $collectors[$collectorId];

            if ($collector->getAddAdminNotification()) {
                $this->adminChannel->execute($notification);
            }

            foreach ($notificationChannels as $channelName => $channelProcessor) {
                $channelItems = $channelsData[$collectorId][$channelName] ?? [];

                if (empty($channelItems)) {
                    continue;
                }

                $channelProcessor->execute($notification, $channelItems);
            }

            $this->addNotificationToLogs($notification);
        }
    }

    protected function getCollectorsAndChannelsData($notifications)
    {
        $collectorIds = [];

        foreach ($notifications as $notification) {
            $collectorIds[] = $notification->getCollectorId();
        }

        $collectorIds = array_unique($collectorIds);

        return [
            $this->collectorRepository->getByIds($collectorIds),
            $this->notificationChannelResolver->getChannelDataByCollectorIds($collectorIds),
        ];
    }

    protected function addNotificationToLogs($notification)
    {
        $message = $notification->getMessage();
        $severity = $notification->getSeverity();

        if ($severity == \MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_NOTICE) {
            $this->logger->info($message);
        } elseif ($severity == \MageSuite\NotificationDashboard\Model\Source\Severity::SEVERITY_CRITICAL) {
            $this->logger->critical($message);
        } else {
            $this->logger->error($message);
        }
    }
}
