<?php

namespace [@VENDOR]\[@MODULE]\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface [@ENTITY_NAME]Interface extends ExtensibleDataInterface
{
    [@GETTERS]

    [@SETTERS]

    /**
     * @return \[@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]ExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * @param \[@VENDOR]\[@MODULE]\Api\Data\[@ENTITY_NAME]ExtensionInterface $extensionAttributes
     * @return void
     */
    public function setExtensionAttributes($extensionAttributes);
}
