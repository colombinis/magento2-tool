<?php

namespace [@VENDOR]\[@MODULE]\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface [@ENTITY_NAME]SearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \[@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]Interface[]
     */
    public function getItems();

    /**
     * @param \[@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]Interface[] $items
     * @return void
     */
    public function setItems(array $items);
}
