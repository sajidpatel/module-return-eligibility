<?php
namespace SajidPatel\ReturnEligibility\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Store\Model\ScopeInterface;

class ReturnEligibilitySettings implements ResolverInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ){
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Resolve the GraphQL query
     */
    public function resolve(
        \Magento\Framework\GraphQl\Config\Element\Field $field,
        $context,
        \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info,
        array $value = null,
        array $args = null
    ){
        $isEnabled = $this->scopeConfig->isSetFlag(
            'catalog/return_eligibility/enable_display',
            ScopeInterface::SCOPE_STORE
        );
        $defaultReturnDays = (int) $this->scopeConfig->getValue(
            'catalog/return_eligibility/default_return_days',
            ScopeInterface::SCOPE_STORE
        );

        return [
            'enable_display' => $isEnabled,
            'default_return_days' => $defaultReturnDays
        ];
    }
}
