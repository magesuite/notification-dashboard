<?php

namespace MageSuite\NotificationDashboard\Block\Adminhtml\Dashboard;

class Notification extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected \MageSuite\NotificationDashboard\Model\ResourceModel\Notification\CollectionFactory $notificationCollectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \MageSuite\NotificationDashboard\Model\ResourceModel\Notification\CollectionFactory $notificationCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $backendHelper, $data);

        $this->notificationCollectionFactory = $notificationCollectionFactory;
    }

    protected function _construct()
    {
        parent::_construct();

        $this->setId(sprintf('dashboard_notification_%s', $this->getData('collector_id')));

        $this->setPagerVisibility(false);
        $this->setFilterVisibility(false);

        $this->setDefaultSort('id');
        $this->setUseAjax(true);
    }

    public function getMainButtonsHtml()
    {
        return null;
    }

    protected function _prepareCollection()
    {
        $collection = $this->notificationCollectionFactory
            ->create()
            ->addFieldToFilter('collector_id', $this->getData('collector_id'))
            ->addOrder('created_at', \Magento\Framework\Data\Collection::SORT_ORDER_DESC);

        $limit = $this->getLimit();

        if ($limit) {
            $collection->getSelect()->limit($limit);
        }

        $collection->load();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'sortable' => true,
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'renderer' => \MageSuite\NotificationDashboard\Block\Adminhtml\Dashboard\Notification\Column\Renderer\UnReadEntry::class
            ]
        );

        $this->addColumn(
            'message',
            [
                'header' => __('Message'),
                'index' => 'message',
                'renderer' => \MageSuite\NotificationDashboard\Block\Adminhtml\Dashboard\Notification\Column\Renderer\UnReadEntry::class
            ]
        );

        $this->addColumn(
            'severity',
            [
                'header' => __('Severity'),
                'index' => 'severity',
                'renderer' => \MageSuite\NotificationDashboard\Block\Adminhtml\Dashboard\Notification\Column\Renderer\Severity::class
            ]
        );

        $this->addColumn(
            'created_at',
            [
                'header' => __('Created At'),
                'type' => 'date',
                'index' => 'created_at'
            ]
        );

        $this->addColumn(
            'is_read',
            [
                'header' => __('Is Read'),
                'index' => 'is_read',
                'renderer' => \MageSuite\NotificationDashboard\Block\Adminhtml\Dashboard\Notification\Column\Renderer\IsMarkedAsRead::class
            ]
        );

        $this->addColumn(
            'action',
            [
                'header' => __('Action'),
                'index' => 'id',
                'renderer' => \MageSuite\NotificationDashboard\Block\Adminhtml\Dashboard\Notification\Column\Renderer\Actions::class
            ]
        );

        return parent::_prepareColumns();
    }
}
