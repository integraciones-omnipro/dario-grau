<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Block\Adminhtml\ContentType\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class AddButton implements ButtonProviderInterface
{
    private AuthorizationInterface $authorization;
    private UrlInterface $urlBuilder;

    public function __construct(
        Context $context
    ) {
        $this->authorization = $context->getAuthorization();
        $this->urlBuilder = $context->getUrlBuilder();
    }

    public function getButtonData(): array
    {
        if (!$this->_isAllowed()) {
            return [];
        }
        return [
            'id' => 'add',
            'label' => __('Add New Featured Product'),
            'on_click' => "setLocation('" . $this->urlBuilder->getUrl('*/*/new') . "')",
            'class' => 'primary',
            'sort_order' => 15
        ];
    }

    protected function _isAllowed(): bool
    {
        return $this->authorization->isAllowed('Omnipro_QuickProductPositioning::featured_products_positioning_edit');
    }
}