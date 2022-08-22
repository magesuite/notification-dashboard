<?php
declare(strict_types=1);

namespace MageSuite\NotificationDashboard\Ui\Component\Form;

class Collector extends \Magento\Ui\Component\Form
{
    public function getDataSourceData()
    {
        $dataSource = [];

        $id = $this->getContext()->getRequestParam($this->getContext()->getDataProvider()->getRequestFieldName(), null);
        $idFieldName = $this->getContext()->getDataProvider()->getPrimaryFieldName();
        $filter = $this->filterBuilder->setField($idFieldName)
            ->setValue($id)
            ->create();
        $this->getContext()->getDataProvider()
            ->addFilter($filter);

        $data = $this->getContext()->getDataProvider()->getData();

        if (isset($data[$id])) {
            $dataSource = [
                'data' => $data[$id]
            ];
        } elseif (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                if ($item[$idFieldName] == $id) {
                    $dataSource = ['data' => ['general' => $item]];
                }
            }
        }
        return $dataSource;
    }
}
