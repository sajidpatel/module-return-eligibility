<?php

namespace SajidPatel\ReturnEligibility\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Registry;
use Magento\Catalog\Model\Product;

class CurrentProduct implements ArgumentInterface
{
    /**
     * @var Registry
     */
    private $registry;

    /**
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * Get current product
     *
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Get current product name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        $product = $this->getCurrentProduct();
        return $product ? $product->getName() : null;
    }

    /**
     * Get current product SKU
     *
     * @return string|null
     */
    public function getSku(): ?string
    {
        $product = $this->getCurrentProduct();
        return $product ? $product->getSku() : null;
    }

    /**
     * Get current product price
     *
     * @return float|null
     */
    public function getPrice(): ?float
    {
        $product = $this->getCurrentProduct();
        return $product ? (float)$product->getPrice() : null;
    }

    /**
     * Check if product is in stock
     *
     * @return bool|null
     */
    public function isInStock(): ?bool
    {
        $product = $this->getCurrentProduct();
        return $product ? $product->isAvailable() : null;
    }

    /**
     * Get product url
     *
     * @return string|null
     */
    public function getProductUrl(): ?string
    {
        $product = $this->getCurrentProduct();
        return $product ? $product->getProductUrl() : null;
    }
}
