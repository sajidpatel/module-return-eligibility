<?php
namespace SajidPatel\ReturnEligibility\Model\Resolver;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;

class ReturnEligibilitySettings implements ResolverInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger
    ){
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
    }

    /**
     * Resolve the GraphQL query
     *
     * @param Field $field
     * @param mixed $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws \Exception
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ): array {
        $this->logger->info('ReturnEligibilitySettings resolver called');

        try {
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
        } catch (\Exception $e) {
            $this->logger->error('Error in ReturnEligibilitySettings resolver: ' . $e->getMessage());
            throw $e;
        }
    }
}
