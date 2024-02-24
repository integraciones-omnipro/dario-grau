<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;

class NewAction extends Action
{
    const ADMIN_RESOURCE = 'Omnipro_QuickProductPositioning::featured_products_positioning_edit';
    private ForwardFactory $forwardFactory;

    public function __construct(
        ForwardFactory $forwardFactory,
        Context $context
    ) {
        parent::__construct($context);
        $this->forwardFactory = $forwardFactory;
    }

    public function execute()
    {
        $resultForward = $this->forwardFactory->create();
        // redirect to index because we are not allowing to create new inputs
        $resultForward->forward('edit');
        //$resultForward->forward('edit');
        return $resultForward;
    }
}