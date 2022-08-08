<?php
declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Ui\Component\Listing\User;

class Actions extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                $item[$name]['edit'] = [
                    'href' => $this->context->getUrl('notification_dashboard/user/edit', [
                        'id' => $item[$item['id_field_name']]
                    ]),
                    'label' => __('Edit'),
                ];
            }
        }
        return $dataSource;
    }
}
