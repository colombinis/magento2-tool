<?php

namespace [@VENDOR]\[@MODULE]\Controller\[@CONTROLLER];

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\JsonFactory;

class [@ACTION] extends Action
{
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory
        )
    {
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
        
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $data = ['message' => 'Hola from'. __FILE__];
        return $result->setData($data);
    }

}

