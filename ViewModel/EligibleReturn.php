<?php

namespace SajidPatel\ReturnEligibility\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class EligibleReturn implements ArgumentInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get config value
     *
     * @param string $path
     * @param string $scope
     * @return mixed
     */
    public function getConfigValue($path, $scope = ScopeInterface::SCOPE_STORE)
    {
        return $this->scopeConfig->getValue($path, $scope);
    }

    /**
     * Check if config flag is enabled
     *
     * @param string $path
     * @param string $scope
     * @return bool
     */
    public function isEnabled($scope = ScopeInterface::SCOPE_STORE)
    {
        return (string) $this->scopeConfig->getValue('catalog/return_eligibility/enabled', $scope);
    }

    /**
     * Get custom message from config
     *
     * @param string $scope
     * @return string
     */
    public function getCustomMessage($scope = ScopeInterface::SCOPE_STORE)
    {
        return (string) $this->scopeConfig->getValue('catalog/return_eligibility/custom_message', $scope);
    }

    /**
     * Get the processed custom message with the days value
     *
     * @param int $days
     * @param string $scope
     * @return string
     */
    public function getProcessedCustomMessage($days, $store = ScopeInterface::SCOPE_STORE)
    {
        $message = $this->getCustomMessage($store);
        return str_replace('{days}', $days, $message);
    }
}
