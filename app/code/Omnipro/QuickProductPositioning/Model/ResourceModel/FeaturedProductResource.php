<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Omnipro\QuickProductPositioning\Api\Data\FeaturedProductInterface;

class FeaturedProductResource extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'omnipro_featured_products_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct(): void
    {
        $this->_init('omnipro_featured_products', FeaturedProductInterface::ENTITY_ID);
        $this->_useIsObjectNew = true;
    }
}
