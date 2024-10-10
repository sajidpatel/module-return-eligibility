<?php

namespace Vendor\EligibleForReturn\Model\Product\Attribute\Backend;

use Magento\Catalog\Model\Product;

class ReturnEligibility extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    public function afterLoad($object)
    {
        $returnEligibilityDays = $object->getData('return_eligibility_days');
        $showReturnEligibility = $object->getData('show_return_eligibility');

        if ($showReturnEligibility && $returnEligibilityDays > 0) {
            $text = sprintf('Eligible for Returns within %d days of delivery.', $returnEligibilityDays);
        } else {
            $text = '';
        }

        $object->setData('return_eligibility_text', $text);

        return parent::afterLoad($object);
    }
}
