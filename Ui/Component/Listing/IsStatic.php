<?php

namespace MageSuite\NotificationDashboard\Ui\Component\Listing;

class IsStatic extends \Magento\Ui\Component\Listing\Columns\Column
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

            if ($item[$fieldName]) {
                $item[$fieldName] = __('Yes');
            } else {
                $item[$fieldName] = __('No');
            }
        }

        return $dataSource;
    }
}
