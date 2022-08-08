<?php

namespace MageSuite\NotificationDashboard\Model\Command\Collector;

class PrepareTypeConfigurationData
{
    protected \Magento\Framework\App\RequestInterface $request;

    protected \Magento\Framework\Serialize\SerializerInterface $serializer;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Serialize\SerializerInterface $serializer
    ) {
        $this->request = $request;
        $this->serializer = $serializer;
    }

    public function execute($data)
    {
        $configurationData = $this->request->getParam($data['type']);

        if (empty($configurationData)) {
            return $data;
        }

        $data['configuration'] = $this->serializer->serialize($configurationData);
        return $data;
    }

    protected function prepareData($data)
    {
        if (is_string($data)) {
            return [$data];
        }

        $result = [];

        foreach ($data as $key => $value) {
            if (is_object($value)) {
                $result[$key] = null;
                continue;
            }

            $result[$key] = $value;
        }

        return $result;
    }
}
