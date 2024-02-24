<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Controller\Adminhtml\Index;

use DateTimeZone;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Omnipro\QuickProductPositioning\Api\FeaturedProductRepositoryInterface;
use Omnipro\QuickProductPositioning\Api\Data\FeaturedProductInterfaceFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use RuntimeException;

class Save extends Action
{
    protected PageFactory $pageFactory;
    protected $messageManager;
    protected FeaturedProductRepositoryInterface $featuredProductRepository;
    protected FeaturedProductInterfaceFactory $featuredProductInterfaceFactory;
    protected DateTime $date;
    protected FilterBuilder $filterBuilder;
    protected SearchCriteriaBuilder $searchCriteriaBuilder;
    protected ProductRepositoryInterface $productRepository;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        FeaturedProductRepositoryInterface $formInputRepository,
        FeaturedProductInterfaceFactory $formInputInterfaceFactory,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        DateTime $date,
        ProductRepositoryInterface $productRepository
    ) {
        $this->pageFactory = $resultPageFactory;
        $this->featuredProductRepository = $formInputRepository;
        $this->featuredProductInterfaceFactory = $formInputInterfaceFactory;
        $this->date = $date;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->productRepository = $productRepository;
        parent::__construct($context);
    }

    /**
     * Save Action
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        // Check data and save / update the Featured Product
        if ($data) {
            $id = (int) $this->getRequest()->getParam('entity_id');
            $time = (new \DateTime())->setTimezone(new DateTimeZone('UTC'));
            if ($id) {
                $model = $this->featuredProductRepository->getById($id);
            } else {
                unset($data['entity_id']);
                $model = $this->featuredProductInterfaceFactory->create();
            }
            try {
                $sku = $data['product_sku'];
                $product = $this->productRepository->get($sku);
                $categories = $data['categories'];
                $sortOrder = (int) $data['sort_order'];
                $productId = (int) $product->getId();
                $productName = $product->getName();
                $model->setProductId($productId);
                $model->setProductSku($sku);
                $model->setCategories($categories);
                $model->setSortOrder($sortOrder);
                $model->setProductName($productName);
                $model->setUpdatedAt($time);
                $this->featuredProductRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved this Featured Product.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getEntityId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException|RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addException(
                    $e,
                    __("Something went wrong while saving the Featured Product: %1", $e->getMessage())
                );
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
