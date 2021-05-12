<?php
namespace [@VENDOR]\[@MODULE]\Model\ResourceModel;

/**
 * Class [@ENTITY_NAME]
 */
class [@ENTITY_NAME] extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Init
     */
    protected function _construct() // phpcs:ignore PSR2.Methods.MethodDeclaration
    {
        /**
         * TODO: verify table name and PRIMARY KEY ???
         */
        $this->_init('[@TABLE_NAME]', 'entity_id');
    }
}
