<?php

namespace [@VENDOR]\[@MODULE]\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use [@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]ExtensionInterface;
use [@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]Interface;

class [@ENTITY_NAME] extends AbstractExtensibleModel implements [@ENTITY_NAME]Interface
{
    [@CONSTANTES]

    protected function _construct()
    {
        $this->_init(\[@VENDOR]\[@MODULE]\Model\ResourceModel\[@ENTITY_NAME]::class);
    }

    [@GETTERS]

    [@SETTERS]

    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    public function setExtensionAttributes($extensionAttributes)
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}
