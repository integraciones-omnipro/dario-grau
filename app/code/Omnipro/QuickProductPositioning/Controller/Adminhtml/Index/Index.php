<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    private PageFactory $pageFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    public function execute(): \Magento\Framework\View\Result\Page|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\App\ResponseInterface
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Omnipro_QuickProductPositioning::featured_product');
        $resultPage->getConfig()->getTitle()->prepend(__('Featured Products Management'));

        return $resultPage;
    }
}