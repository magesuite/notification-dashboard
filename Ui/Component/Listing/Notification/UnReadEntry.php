<?php

namespace MageSuite\NotificationDashboard\Ui\Component\Listing\Notification;

class UnReadEntry extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        $fieldName = $this->getData('name');

        foreach ($dataSource['data']['items'] as &$item) {
            if ($item['is_read']) {
                continue;
            }

            $item[$fieldName] = sprintf('<strong>%s</strong>', $item[$fieldName]);
        }

        return $dataSource;
    }
}
