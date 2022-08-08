<?php

namespace MageSuite\NotificationDashboard\Model\Command\Notification;

class AddRawDataToMessage
{
    const MESSAGE_WITH_DATA_FORMAT = "%s\n\nRaw data: %s";

    public function execute($notification)
    {
        $rawData = $notification->getRawData();

        if (empty($rawData)) {
            return $notification->getMessage();
        }

        $rawData = $this->prepareRawData($rawData);
        return sprintf(self::MESSAGE_WITH_DATA_FORMAT, $notification->getMessage(), var_export($rawData, true));
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