<?php

namespace MageSuite\NotificationDashboard\Service\NotificationSender\Channel;

class Resolver
{
    const CHANNEL_TYPE_NAME_PREFIX = 'send_to_';

    protected \MageSuite\NotificationDashboard\Model\UserRepository $userRepository;

    protected \MageSuite\NotificationDashboard\Model\CollectorUserRepository $collectorUserRepository;

    protected array $channels = [];

    public function __construct(
        \MageSuite\NotificationDashboard\Model\UserRepository $userRepository,
        \MageSuite\NotificationDashboard\Model\CollectorUserRepository $collectorUserRepository,
        array $channels
    ) {
        $this->userRepository = $userRepository;
        $this->collectorUserRepository = $collectorUserRepository;
        $this->channels = $channels;
    }

    public function getAllChannels()
    {
        return $this->channels;
    }

    public function getChannelDataByCollectorIds($collectorIds)
    {
        $users = $this->userRepository->getList()->getItems();
        $collectorUsers = $this->collectorUserRepository->getByCollectorIds($collectorIds);

        $channels = $this->getAllChannels();

        $channelDataGropedByCollector = [];

        foreach ($collectorUsers as $collectorUser) {
            $collectorId = $collectorUser->getCollectorId();
            $user = $users[$collectorUser->getUserId()];

            foreach ($channels as $channelName => $channelProcessor) {
                if (!$collectorUser->getData($channelName)) {
                    continue;
                }

                $channelNameWithoutPrefix = str_replace(self::CHANNEL_TYPE_NAME_PREFIX, '', $channelName);
                $channelDataGropedByCollector[$collectorId][$channelName][] = $user->getData($channelNameWithoutPrefix);
            }
        }

        return $channelDataGropedByCollector;
    }
}
