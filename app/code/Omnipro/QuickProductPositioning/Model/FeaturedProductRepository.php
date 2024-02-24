<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Omnipro\QuickProductPositioning\Api\Data\FeaturedProductSearchResultsInterface;
use Omnipro\QuickProductPositioning\Api\Data\FeaturedProductSearchResultsInterfaceFactory;
use Omnipro\QuickProductPositioning\Api\FeaturedProductRepositoryInterface;
use Omnipro\QuickProductPositioning\Api\Data\FeaturedProductInterface;
use Omnipro\QuickProductPositioning\Model\FeaturedProductModel;
use Omnipro\QuickProductPositioning\Model\FeaturedProductModelFactory;
use Omnipro\QuickProductPositioning\Model\ResourceModel\FeaturedProductResource;
use Omnipro\QuickProductPositioning\Model\ResourceModel\FeaturedProductModel\FeaturedProductCollection;
use Omnipro\QuickProductPositioning\Model\ResourceModel\FeaturedProductModel\FeaturedProductCollectionFactory;

class FeaturedProductRepository implements FeaturedProductRepositoryInterface
{
    private FeaturedProductResource $featuredProductResource;
    private FeaturedProductModelFactory $featuredProductFactory;
    private FeaturedProductCollectionFactory $featuredProductCollectionFactory;
    private CollectionProcessorInterface $collectionProcessor;
    private FeaturedProductSearchResultsInterfaceFactory $featuredProductSearchResultsInterfaceFactory;

    public function __construct(
        FeaturedProductResource $formInputResource,
        FeaturedProductModelFactory $formInputFactory,
        FeaturedProductCollectionFactory $formInputCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        FeaturedProductSearchResultsInterfaceFactory $formInputSearchResultsInterfaceFactory
    ) {
        $this->featuredProductResource = $formInputResource;
        $this->featuredProductFactory = $formInputFactory;
        $this->featuredProductCollectionFactory = $formInputCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->featuredProductSearchResultsInterfaceFactory = $formInputSearchResultsInterfaceFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function save(FeaturedProductInterface $featuredProduct): FeaturedProductInterface
    {
        if (!($featuredProduct instanceof AbstractModel)) {
            throw new CouldNotSaveException(__('The implementation of FeaturedProductInterface has changed'));
        }

        try {
            $this->featuredProductResource->save($featuredProduct);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $featuredProduct;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($featuredProductId): FeaturedProductInterface
    {
        /** @var FeaturedProductModel $featuredProduct */
        $featuredProduct = $this->featuredProductFactory->create();
        $this->featuredProductResource->load($featuredProduct, $featuredProductId);

        if (!$featuredProduct->getId()) {
            throw new NoSuchEntityException(__('The featured product could not be found'));
        }
        return $featuredProduct;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(FeaturedProductInterface $featuredProduct): bool
    {
        if (!($featuredProduct instanceof AbstractModel)) {
            throw new CouldNotDeleteException(__('The implementation of FeaturedProductInterface has changed'));
        }

        try {
            $this->featuredProductResource->delete($featuredProduct);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($entityId): bool
    {
        return $this->delete($this->getById($entityId));
    }

    public function getList(SearchCriteriaInterface $searchCriteria): FeaturedProductSearchResultsInterface
    {
        /** @var FeaturedProductCollection $collection */
        $collection = $this->featuredProductFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var FeaturedProductSearchResultsInterface $searchResults */
        $searchResults = $this->featuredProductSearchResultsInterfaceFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}