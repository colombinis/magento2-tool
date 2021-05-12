<?php

namespace [@VENDOR]\[@MODULE]\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class [@EVENT_CLASS]
 */
class [@EVENT_CLASS] implements ObserverInterface
{
    /**
     * @var Logger
     */
    protected $_logger;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->_logger = $logger;
    }

    /**
     * Short description for another dev or myself in the future
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var $orderInstance Order */
        //$orderInstance = $observer->getOrder();
        $msg= "executed from observer " . __FILE__;
        $this->_examplePrivateMethod($msg);
    }

    /**
     * Example to log somthing
     *
     * @return null
     */
    private function _examplePrivateMethod($msg)
    {
        $this->_logger->info($msg);
    }
}
