<?php
namespace MageSuite\NotificationDashboard\Ui\DataProvider\Listing;

class User extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    protected \MageSuite\NotificationDashboard\Api\UserRepositoryInterface $userRepository;

    protected \Magento\Ui\DataProvider\SearchResultFactory $searchResultFactory;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Magento\Framework\Api\Search\ReportingInterface $reporting,
        \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \MageSuite\NotificationDashboard\Api\UserRepositoryInterface $userRepository,
        \Magento\Ui\DataProvider\SearchResultFactory $searchResultFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $reporting, $searchCriteriaBuilder, $request, $filterBuilder, $meta, $data);

        $this->userRepository = $userRepository;
        $this->searchResultFactory = $searchResultFactory;
    }

    public function getSearchResult()
    {
        $searchCriteria = $this->getSearchCriteria();
        $result = $this->userRepository->getList($searchCriteria);

        return $this->searchResultFactory->create(
            $result->getItems(),
            $result->getTotalCount(),
            $searchCriteria,
            'id'
        );
    }
}
