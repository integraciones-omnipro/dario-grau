<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Block\Adminhtml\FeaturedProduct\Edit\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Save extends Generic implements ButtonProviderInterface
{
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData(): array
    {
        if (!$this->_isAllowed()) {
            return [];
        }

        return [
            'label' => __('Save Featured Product'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }

    protected function _isAllowed(): bool
    {
        return $this->authorization->isAllowed('Omnipro_QuickProductPositioning::featured_products_positioning_edit');
    }
}