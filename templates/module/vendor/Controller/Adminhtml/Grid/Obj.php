<?php

namespace [@VENDOR]\[@MODULE]\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;

/**
 * [@ENTITY_NAME] Controller
 */
class [@ENTITY_NAME] extends Action
{
    protected $resultPageFactory = false;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend((__('Lista [@ENTITY_NAME]')));

		return $resultPage;
	}
}
