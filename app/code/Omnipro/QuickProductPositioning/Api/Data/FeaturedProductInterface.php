<?php
declare(strict_types=1);

namespace Omnipro\QuickProductPositioning\Api\Data;

interface FeaturedProductInterface
{
    const ENTITY_ID = 'entity_id';
    const PRODUCT_ID = 'product_id';
    const PRODUCT_SKU = 'product_sku';
    const PRODUCT_NAME = 'product_name';
    const CATEGORIES = 'categories';
    const SORT_ORDER = 'sort_order';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Retrieve entity id
     */
    public function getEntityId();

    /**
     * Getter for ProductId.
     * @return int|null
     */
    public function getProductId(): ?int;

    /**
     * Setter for ProductId.
     * @param int|null $productId
     * @return void
     */
    public function setProductId(?int $productId): void;

    /**
     * Getter for ProductSku.
     * @return string|null
     */
    public function getProductSku(): ?string;

    /**
     * Setter for ProductSku.
     * @param string|null $productSku
     * @return void
     */
    public function setProductSku(?string $productSku): void;

    /**
     * Getter for ProductName.
     * @return string|null
     */
    public function getProductName(): ?string;

    /**
     * Setter for ProductName.
     * @param string|null $productName
     * @return void
     */
    public function setProductName(?string $productName): void;

    /**
     * Getter for Categories.
     * @return string|null
     */
    public function getCategories(): ?string;

    /**
     * Setter for Categories.
     * @param string|null $categories
     * @return void
     */
    public function setCategories(?string $categories): void;

    /**
     * Getter for SortOrder.
     * @return int|null
     */
    public function getSortOrder(): ?int;

    /**
     * Setter for SortOrder.
     * @param int|null $sortOrder
     * @return void
     */
    public function setSortOrder(?int $sortOrder): void;

    /**
     * Getter for CreatedAt.
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Setter for CreatedAt.
     * @param string|null $createdAt
     * @return void
     */
    public function setCreatedAt(?string $createdAt): void;

    /**
     * Getter for UpdatedAt.
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Setter for UpdatedAt.
     * @param \DateTime $value
     * @return void
     */
    public function setUpdatedAt(\DateTime $value): void;
}