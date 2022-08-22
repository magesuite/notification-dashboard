<?php
declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Ui\Component\Listing\Notification;

class Actions extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function prepareDataSource(array $dataSource): array
    {
        if (! isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            $name = $this->getData('name');

            $item[$name] = [
                'mark_as_read' => [
                    'href' => $this->context->getUrl('notification_dashboard/notification/markAsRead', [
                        'id' => $item[$item['id_field_name']]
                    ]),
                    'label' => __('Mark as Read'),
                ],
                'delete' => [
                    'href' => $this->context->getUrl('notification_dashboard/notification/delete', [
                        'id' => $item[$item['id_field_name']]
                    ]),
                    'label' => __('Delete'),
                ]
            ];
        }

        return $dataSource;
    }
}
