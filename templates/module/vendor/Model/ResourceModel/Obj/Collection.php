<?php
namespace [@VENDOR]\[@MODULE]\Model\ResourceModel\[@ENTITY_NAME];

/**
 * Class Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        $this->_init(
            \[@VENDOR]\[@MODULE]\Model\[@ENTITY_NAME]::class,
            \[@VENDOR]\[@MODULE]\Model\ResourceModel\[@ENTITY_NAME]::class
        );
    }
}
