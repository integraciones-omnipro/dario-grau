<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Catalog\Api\CategoryRepositoryInterface;

class Categories extends Column
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CategoryRepositoryInterface $categoryRepository,
        array $components = [],
        array $data = []
    ) {
        $this->categoryRepository = $categoryRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if ($item['categories']) {
                    $names = [];
                    $ids = explode(',', $item['categories']);
                    foreach($ids as $id){
                        $category = $this->categoryRepository->get($id);
                        $names[] = $category->getName();
                    }
                    $item['categories'] = implode(", ", $names);
                }
            }
        }
        return $dataSource;
    }
}