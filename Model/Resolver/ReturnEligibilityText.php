<?php

namespace SajidPatel\ReturnEligibility\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Catalog\Api\ProductRepositoryInterface;

class ReturnEligibilityText implements ResolverInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    protected $eligibleReturnConfig;

    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($args['product_sku']) || empty($args['product_sku'])) {
            throw new GraphQlInputException(__('Product SKU should be specified'));
        }

        $productSku = $args['product_sku'];

        try {
            $product = $this->productRepository->get($productSku);
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__('Product with SKU "%1" does not exist.', $productSku));
        }

        // Here you would implement your logic to determine the return eligibility
        // This is a placeholder implementation
        $isEligible = $this->checkReturnEligibility($product);
        $daysToReturn = $this->getReturnPeriod($product);

        if ($isEligible) {
            return sprintf("This item is eligible for return within %d days of delivery.", $daysToReturn);
        } else {
            return "This item is not eligible for return.";
        }
    }

    /**
     * Check if the product is eligible for return
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return bool
     */
    private function checkReturnEligibility($product)
    {

        // Implement your logic here
        // This is a placeholder implementation
        return true;
    }

    /**
     * Get the return period for the product
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return int
     */
    private function getReturnPeriod($product)
    {
        // Implement your logic here
        // This is a placeholder implementation
        return 30;
    }
}
