<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Api;

use Omnipro\QuickProductPositioning\Api\Data\FeaturedProductInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface FeaturedProductRepositoryInterface
{
    /**
     * Save FeaturedProduct
     * @param \Omnipro\QuickProductPositioning\Api\Data\FeaturedProductInterface $featuredProduct
     * @return \Omnipro\QuickProductPositioning\Api\Data\FeaturedProductInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(FeaturedProductInterface $featuredProduct);

    /**
     * Retrieve FeaturedProduct by ID
     * @param string $entityId
     * @return \Omnipro\QuickProductPositioning\Api\Data\FeaturedProductInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($entityId);

    /**
     * Delete FeaturedProduct
     * @param \Omnipro\QuickProductPositioning\Api\Data\FeaturedProductInterface $featuredProduct
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(FeaturedProductInterface $featuredProduct);

    /**
     * Delete FeaturedProduct by ID
     * @param string $entityId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($entityId);

    /**
     * Retrieve FeaturedProduct matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}