<?php

namespace MageSuite\NotificationDashboard\Service\NotificationSender\Channel;

class Resolver
{
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

                $channelDataGropedByCollector[$collectorId][$channelName][] = $user->getData($channelName);
            }
        }

        return $channelDataGropedByCollector;
    }
}
