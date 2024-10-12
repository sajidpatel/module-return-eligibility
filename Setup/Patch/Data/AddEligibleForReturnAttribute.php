<?php
namespace SajidPatel\ReturnEligibility\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Product;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddEligibleForReturnAttribute implements DataPatchInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Constructor
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory
    ){
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Apply the data patch
     */
    public function apply()
    {
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create();

        $eavSetup->addAttribute(
            Product::ENTITY,
            'eligible_for_return_days',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Eligible for Return (Days)',
                'input' => 'text',
                'class' => '',
                'source' => '',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '30', // Optionally set a default value
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => '',
                'group' => 'General',
            ]
        );

        // Get all attribute sets
        $attributeSets = $eavSetup->getAllAttributeSetIds(\Magento\Catalog\Model\Product::ENTITY);

        // Add the attribute to all attribute sets
        foreach ($attributeSets as $attributeSet) {
            $eavSetup->addAttributeToSet(
                \Magento\Catalog\Model\Product::ENTITY,
                $attributeSet,
                'General', // You can change this to any other group name
                'eligible_for_return_days'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
