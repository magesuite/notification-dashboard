<?php

namespace MageSuite\NotificationDashboard\Ui\Component\Listing\Notification;

class IsMarkedAsRead extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        $fieldName = $this->getData('name');

        foreach ($dataSource['data']['items'] as &$item) {
            if ($item[$fieldName] === null) {
                continue;
            }

            $item[$fieldName] = $item[$fieldName] ? __('Yes') : __('No');
        }

        return $dataSource;
    }
}
