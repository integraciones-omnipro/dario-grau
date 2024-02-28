<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Model;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Omnipro\QuickProductPositioning\Model\ResourceModel\FeaturedProductModel\FeaturedProductCollectionFactory;

class DataProvider extends AbstractDataProvider
{
    protected ?array $loadedData = null;
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        FeaturedProductCollectionFactory $featuredProductCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $featuredProductCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array The data for the object.
     */
    public function getData(): array
    {
        if (null === $this->loadedData) {
            $this->loadedData = [];

            $items = $this->collection->getItems();

            foreach ($items as $item) {
                $itemData = $item->getData();
                $itemData['products'] = $itemData['product_id'];
                $itemData['categories'] = explode(',', $itemData['categories']);
                $this->loadedData[$item->getEntityId()] = $itemData;
            }
        }

        return $this->loadedData;
    }
}