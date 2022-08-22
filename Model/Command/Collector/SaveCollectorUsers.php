<?php

namespace MageSuite\NotificationDashboard\Model\Command\Collector;

class SaveCollectorUsers
{
    protected \MageSuite\NotificationDashboard\Api\CollectorUserRepositoryInterface $collectorUserRepository;

    protected \MageSuite\NotificationDashboard\Model\Data\CollectorUserFactory $collectorUserFactory;

    public function __construct(
        \MageSuite\NotificationDashboard\Api\CollectorUserRepositoryInterface $collectorUserRepository,
        \MageSuite\NotificationDashboard\Model\Data\CollectorUserFactory $collectorUserFactory
    ) {
        $this->collectorUserRepository = $collectorUserRepository;
        $this->collectorUserFactory = $collectorUserFactory;
    }

    public function execute($collectorId, $formData)
    {
        $collectorUsers = $this->collectorUserRepository->getByCollectorIds([$collectorId]);

        $collectorUsersData = [];

        foreach ($formData as $collectorUserData) {
            $collectorUserData['collector_id'] = $collectorId;

            if (isset($collectorUserData['id'])) {
                $collectorUsersData[$collectorUserData['id']] = $collectorUserData;
            } else {
                $collectorUser = $this->collectorUserFactory->create();

                $collectorUser->setData($collectorUserData);
                $this->collectorUserRepository->save($collectorUser);
            }
        }

        foreach ($collectorUsers as $collectorUser) {
            if (isset($collectorUsersData[$collectorUser->getId()])) {
                $collectorUserData = $collectorUsersData[$collectorUser->getId()];

                $collectorUser->setData($collectorUserData);
                $this->collectorUserRepository->save($collectorUser);
            } else {
                $this->collectorUserRepository->delete($collectorUser);
            }
        }
    }
}
