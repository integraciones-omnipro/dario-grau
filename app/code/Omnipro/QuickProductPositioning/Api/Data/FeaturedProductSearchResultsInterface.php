<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface FeaturedProductSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Omnipro\QuickProductPositioning\Api\Data\FeaturedProductInterface[]
     */
    public function getItems();

    /**
     * @param \Omnipro\QuickProductPositioning\Api\Data\FeaturedProductInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}