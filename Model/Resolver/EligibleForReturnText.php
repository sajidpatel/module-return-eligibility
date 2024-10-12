<?php

namespace SajidPatel\ReturnEligibility\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Catalog\Api\ProductRepositoryInterface;

class EligibleForReturnText implements ResolverInterface
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $productId = $args['product_id'];
        $product = $this->productRepository->getById($productId);
        $days = $product->getData('eligible_for_return_days');

        if ($days > 0) {
            return sprintf('Eligible for Returns within %d days of delivery.', $days);
        }

        return '';
    }
}
