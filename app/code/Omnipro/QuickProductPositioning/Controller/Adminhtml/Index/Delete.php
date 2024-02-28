<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Omnipro\QuickProductPositioning\Api\FeaturedProductRepositoryInterface;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;

class Delete extends Action
{
    protected FeaturedProductRepositoryInterface $featuredProductRepository;

    public function __construct(
        Context $context,
        FeaturedProductRepositoryInterface $featuredProductRepository
    ) {
        $this->featuredProductRepository = $featuredProductRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                $featuredProduct = $this->featuredProductRepository->getById($id);

                // TODO: Remove the catalog_category_product relation

                $this->featuredProductRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(
                    __(
                        'You have deleted the Featured Product ID:  %entityId.',
                        ['entityId' => $featuredProduct ? $featuredProduct->getEntityId() : '']
                    )
                );
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong. Please try again later.'));
            }
        }
        $resultRedirect->setPath('*/*/');
        return $resultRedirect;
    }

    /**
     * Check Dispersion History Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Omnipro_QuickProductPositioning::featured_products_positioning_edit');
    }
}