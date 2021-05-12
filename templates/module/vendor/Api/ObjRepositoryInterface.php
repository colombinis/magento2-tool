<?php

namespace [@VENDOR]\[@MODULE]\Api;


use Magento\Framework\Api\SearchCriteriaInterface;
use [@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]Interface;

interface [@ENTITY_NAME]RepositoryInterface
{
    /**
     * @param int $id
     * @return \[@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]Interface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

	/**
     * @param int $id
	 * @param \[@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]Interface $item
     * @return \[@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]Interface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function updateById($id, [@ENTITY_NAME]Interface $item);

    /**
     * @param \[@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]Interface $item
     * @return \[@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]Interface
     */
    public function save([@ENTITY_NAME]Interface $item);


    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \[@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]SearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);


}
