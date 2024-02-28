<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Model;

use Magento\Framework\Model\AbstractModel;
use Omnipro\QuickProductPositioning\Api\Data\FeaturedProductInterface;
use Omnipro\QuickProductPositioning\Model\ResourceModel\FeaturedProductResource;

class FeaturedProductModel extends AbstractModel implements FeaturedProductInterface
{
    protected $_eventPrefix = 'omnipro_featured_products_model';

    protected function _construct(): void
    {
        $this->_init(FeaturedProductResource::class);
    }

    public function getProductId(): ?int
    {
        return (int) $this->getData(self::PRODUCT_ID);
    }

    public function setProductId(?int $productId): void
    {
        $this->setData(self::PRODUCT_ID, $productId);
    }

    public function getProductSku(): ?string
    {
        return $this->getData(self::PRODUCT_SKU);
    }

    public function setProductSku(?string $productSku): void
    {
        $this->setData(self::PRODUCT_SKU, $productSku);
    }

    public function getProductName(): ?string
    {
        return $this->getData(self::PRODUCT_NAME);
    }

    public function setProductName(?string $productName): void
    {
        $this->setData(self::PRODUCT_NAME, $productName);
    }

    public function getCategories(): ?string
    {
        return $this->getData(self::CATEGORIES);
    }

    public function setCategories(?string $categories): void
    {
        $this->setData(self::CATEGORIES, $categories);
    }

    public function getSortOrder(): ?int
    {
        return (int) $this->getData(self::SORT_ORDER);
    }

    public function setSortOrder(?int $sortOrder): void
    {
        $this->setData(self::SORT_ORDER, $sortOrder);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }

    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function setUpdatedAt(string|\DateTime|null $value): void
    {
        $this->setData('updated_at', $value->format('Y-m-d H:i:s'));
    }
}