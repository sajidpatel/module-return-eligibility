<?php

namespace SajidPatel\ReturnEligibility\Api\Data;

interface ProductReturnEligibilityInterface
{
    /**
     * @return int|null
     */
    public function getReturnEligibilityDays();

    /**
     * @return bool|null
     */
    public function getShowReturnEligibility();

    /**
     * @return string|null
     */
    public function getReturnEligibilityText();
}
