<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Model;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Omnipro\QuickProductPositioning\Model\ResourceModel\FeaturedProductModel\FeaturedProductCollectionFactory;

class DataProvider extends AbstractDataProvider
{
    private PoolInterface $pool;

    protected $loadedData;
    protected $collection;

    protected $dataPersistor;

    public function __construct(
        FeaturedProductCollectionFactory $featuredProductCollectionFactory,
        PoolInterface $pool,
        $name,
        $primaryFieldName,
        $requestFieldName,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $featuredProductCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->pool = $pool;
        $this->meta = $this->prepareMeta($this->meta);
    }

    public function prepareMeta(array $meta): array
    {
        $meta = parent::getMeta();

        /** @var ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }
        return $meta;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('omnipro_featured_products_model');
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('omnipro_featured_products_model');
        }

        return $this->loadedData;
    }
}