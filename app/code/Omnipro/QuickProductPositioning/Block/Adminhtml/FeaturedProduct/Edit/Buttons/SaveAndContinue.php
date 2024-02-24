<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Block\Adminhtml\FeaturedProduct\Edit\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveAndContinue extends Generic implements ButtonProviderInterface
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
            'label' => __('Save and Continue Edit'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => [
                    'button' => ['event' => 'saveAndContinueEdit'],
                ],
            ],
            'sort_order' => 80,
        ];
    }

    protected function _isAllowed(): bool
    {
        return $this->authorization->isAllowed('Omnipro_QuickProductPositioning::featured_products_positioning_edit');
    }
}
