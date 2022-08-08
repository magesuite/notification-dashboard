<?php
namespace MageSuite\NotificationDashboard\Ui\DataProvider\Listing;

class Collector extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    protected \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository;

    protected \Magento\Ui\DataProvider\SearchResultFactory $searchResultFactory;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Magento\Framework\Api\Search\ReportingInterface $reporting,
        \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \MageSuite\NotificationDashboard\Api\CollectorRepositoryInterface $collectorRepository,
        \Magento\Ui\DataProvider\SearchResultFactory $searchResultFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $reporting, $searchCriteriaBuilder, $request, $filterBuilder, $meta, $data);

        $this->collectorRepository = $collectorRepository;
        $this->searchResultFactory = $searchResultFactory;
    }

    public function getSearchResult()
    {
        $searchCriteria = $this->getSearchCriteria();
        $result = $this->collectorRepository->getList($searchCriteria);

        return $this->searchResultFactory->create(
            $result->getItems(),
            $result->getTotalCount(),
            $searchCriteria,
            'id'
        );
    }
}
