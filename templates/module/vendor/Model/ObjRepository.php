<?php

namespace [@VENDOR]\[@MODULE]\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use [@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]Interface;
use [@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]SearchResultInterface;
use [@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]SearchResultInterfaceFactory;
use [@VENDOR]\[@MODULE]\Api\[@ENTITY_NAME]RepositoryInterface;
use [@VENDOR]\[@MODULE]\Model\ResourceModel\[@ENTITY_NAME]\CollectionFactory as itemsCollectionFactory;
use [@VENDOR]\[@MODULE]\Model\ResourceModel\[@ENTITY_NAME]\Collection;


class [@ENTITY_NAME]Repository implements [@ENTITY_NAME]RepositoryInterface
{
    /**
     * @var [@ENTITY_NAME]Factory
     */
    private $[@ENTITY_NAME]Factory;

    /**
     * @var itemsCollectionFactory
     */
    private $itemsCollectionFactory;

    /**
     * @var [@ENTITY_NAME]SearchResultInterfaceFactory
     */
    private $searchResultFactory;


    public function __construct(
        [@ENTITY_NAME]Factory $[@ENTITY_NAME]Factory,
        itemsCollectionFactory $itemsCollectionFactory,
        [@ENTITY_NAME]SearchResultInterfaceFactory $[@ENTITY_NAME]SearchResultInterfaceFactory
    ) {
        $this->[@ENTITY_NAME]Factory = $[@ENTITY_NAME]Factory;
        $this->itemsCollectionFactory = $itemsCollectionFactory;
        $this->searchResultFactory = $[@ENTITY_NAME]SearchResultInterfaceFactory;
    }

    public function getById($id)
    {
        $[@ENTITY_NAME] = $this->[@ENTITY_NAME]Factory->create();
        $[@ENTITY_NAME]->getResource()->load($[@ENTITY_NAME], $id);
        if (!$[@ENTITY_NAME]->getId()) {
            throw new NoSuchEntityException(__('Unable to find [@ENTITY_NAME] with ID "%1"', $id));
        }
        return $[@ENTITY_NAME];
    }

	public function updateById($id, [@ENTITY_NAME]Interface $item)
    {
		$item->setId($id);
		$item->getResource()->save($item);
    }

    public function save([@ENTITY_NAME]Interface $[@ENTITY_NAME])
    {
        $[@ENTITY_NAME]->getResource()->save($[@ENTITY_NAME]);
        return $[@ENTITY_NAME];
    }



    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->itemsCollectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

}
