<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Model\ResourceModel\FeaturedProductModel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Omnipro\QuickProductPositioning\Model\FeaturedProductModel;
use Omnipro\QuickProductPositioning\Model\ResourceModel\FeaturedProductResource;

class FeaturedProductCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'omnipro_featured_products_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct(): void
    {
        $this->_init(FeaturedProductModel::class, FeaturedProductResource::class);
    }
}
