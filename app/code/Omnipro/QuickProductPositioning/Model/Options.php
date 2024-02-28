<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface
{
    protected CollectionFactory $productCollectionFactory;

    public function __construct(
        CollectionFactory $productCollectionFactory
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
    }

    public function toOptionArray(): array
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('name');
        $options = [];
        foreach ($collection as $product) {
            $options[] = [
                'value' => $product->getId(),
                'label' => $product->getSku(),
            ];
        }
        return $options;
    }
}