<?php

namespace MageSuite\NotificationDashboard\Model\Source;

class User implements \Magento\Framework\Data\OptionSourceInterface
{
    protected \MageSuite\NotificationDashboard\Model\UserRepository $userRepository;

    protected ?array $options = null;

    public function __construct(\MageSuite\NotificationDashboard\Model\UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $users = $this->userRepository->getList();
        $options = [];

        foreach ($users->getItems() as $user) {
            $options[] = [
                'value' => $user->getId(),
                'label' => $user->getName()
            ];
        }

        $this->options = $options;
        return $this->options;
    }
}
