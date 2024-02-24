<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    private PageFactory $pageFactory;

    public function __construct(
        PageFactory $pageFactory,
        Context $context
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        $entityId = $this->getRequest()->getParam('entity_id');
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Omnipro_QuickProductPositioning::featured_product');

        if ($entityId === null) {
            $resultPage->getConfig()->getTitle()->prepend(__('New Featured Product'));
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Featured Product'));
        }
        return $resultPage;
    }
}