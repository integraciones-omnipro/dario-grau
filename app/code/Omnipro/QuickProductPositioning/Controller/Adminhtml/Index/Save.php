<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Controller\Adminhtml\Index;

use DateTimeZone;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Omnipro\QuickProductPositioning\Api\FeaturedProductRepositoryInterface;
use Omnipro\QuickProductPositioning\Api\Data\FeaturedProductInterfaceFactory;
use RuntimeException;

use Magento\Catalog\Api\CategoryLinkRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryProductLinkInterfaceFactory;

class Save extends Action
{
    protected FeaturedProductRepositoryInterface $featuredProductRepository;
    protected FeaturedProductInterfaceFactory $featuredProductInterfaceFactory;
    protected ProductRepositoryInterface $productRepository;
    protected CategoryLinkManagementInterface $categoryLinkManagement;
    protected $messageManager;
    private CategoryLinkRepositoryInterface $categoryLinkRepository;
    private CategoryProductLinkInterfaceFactory $productLinkFactory;

    public function __construct(
        Context $context,
        FeaturedProductRepositoryInterface $featuredProductRepository,
        FeaturedProductInterfaceFactory $featuredProductInterfaceFactory,
        ProductRepositoryInterface $productRepository,
        CategoryLinkManagementInterface $categoryLinkManagement,
        CategoryLinkRepositoryInterface $categoryLinkRepository,
        CategoryProductLinkInterfaceFactory $productLinkFactory
    ) {
        $this->featuredProductRepository = $featuredProductRepository;
        $this->featuredProductInterfaceFactory = $featuredProductInterfaceFactory;
        $this->productRepository = $productRepository;
        $this->categoryLinkManagement = $categoryLinkManagement;
        $this->categoryLinkRepository = $categoryLinkRepository;
        $this->productLinkFactory = $productLinkFactory;
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
                $productId = $data['products'];
                $product = $this->productRepository->getById($productId);
                $categories = implode(",", $data['categories']);
                $sortOrder = (int) $data['sort_order'];
                $sku = $product->getSku();
                $productName = $product->getName();
                $model->setProductId((int)$productId);
                $model->setProductSku($sku);
                $model->setCategories($categories);
                $model->setSortOrder($sortOrder);
                $model->setProductName($productName);
                $model->setUpdatedAt($time);
                $this->featuredProductRepository->save($model);

                // TODO: check what is the lowest position so we put the featured product in the corresponding position
                // Update the catalog category product table
                foreach ($data['categories'] as $categoryId) {
                    $link = $this->productLinkFactory->create();
                    $link->setSku($sku)
                        ->setCategoryId($categoryId)
                        ->setPosition($sortOrder);
                    $this->categoryLinkRepository->save($link);
                }

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
