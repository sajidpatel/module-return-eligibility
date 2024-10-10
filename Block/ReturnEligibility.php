<?php
namespace SajidPatel\ReturnEligibility\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;

class ReturnEligibility extends Template
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Constructor
     *
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->scopeConfig = $context->getScopeConfig();
    }

    /**
     * Get Return Eligibility Message
     *
     * @return string|null
     */
    public function getReturnEligibilityMessage()
    {
        $isEnabled = $this->scopeConfig->isSetFlag(
            'catalog/return_eligibility/enable_display',
            ScopeInterface::SCOPE_STORE
        );

        if (!$isEnabled) {
            return null;
        }

        /** @var \Magento\Catalog\Model\Product $product */
        $product = $this->getProduct();

        $returnDays = $product->getData('eligible_for_return_days');

        if (!$returnDays) {
            $returnDays = (int) $this->scopeConfig->getValue(
                'catalog/return_eligibility/default_return_days',
                ScopeInterface::SCOPE_STORE
            );
        }

        if ($returnDays) {
            return __('Eligible for Returns within %1 days of delivery.', $returnDays);
        }

        return null;
    }

    /**
     * Get Current Product
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        return $this->registry->registry('current_product');
    }
}
