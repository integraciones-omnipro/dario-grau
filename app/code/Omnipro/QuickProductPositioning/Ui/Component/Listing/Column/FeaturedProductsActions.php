<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Ui\Component\Listing\Column;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class FeaturedProductsActions extends Column
{
    const GRID_URL_PATH_EDIT = 'featuredproducts/index/edit';
    const GRID_URL_PATH_DELETE = 'featuredproducts/index/delete';

    private UrlInterface $urlBuilder;
    private AuthorizationInterface $authorization;

    public function __construct(
        UrlInterface $urlBuilder,
        AuthorizationInterface $authorization,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->authorization = $authorization;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (!$this->_isAllowed()) {
            return $dataSource;
        }

        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['entity_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::GRID_URL_PATH_EDIT,
                                [
                                    'entity_id' => $item['entity_id']
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::GRID_URL_PATH_DELETE,
                                [
                                    'entity_id' => $item['entity_id']
                                ]
                            ),
                            'label' => __('Delete')
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }

    /**
     * Prepare component configuration
     * @return void
     * @throws LocalizedException
     */
    public function prepare()
    {
        parent::prepare();
        if (!$this->_isAllowed()) {
            $this->_data['config']['componentDisabled'] = true;
        }
    }

    protected function _isAllowed(): bool
    {
        return $this->authorization->isAllowed('Omnipro_QuickProductPositioning::featured_products_positioning_edit');
    }
}