<?php declare(strict_types=1);

namespace Flavio\NewBadge\Setup\Patch\Data;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Attribute;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddIsNewAttributeToProductEntity implements DataPatchInterface
{
    const ATTRIBUTE_CODE = 'is_new';
    const ATTRIBUTE_LABEL = 'Is New';
    public function __construct(
        private readonly Attribute $attribute,
        private readonly Config $config,
        private readonly EavSetupFactory $eavSetupFactory,
        private readonly ModuleDataSetupInterface $moduleDataSetup
    ){}

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return  [];
    }

    public function apply(): self
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            ProductAttributeInterface::ENTITY_TYPE_CODE,
            self::ATTRIBUTE_CODE,
            [
                'type' => 'int',
                'label' => self::ATTRIBUTE_LABEL,
                'input' => 'select',
                'source' => Boolean::class,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'default' => 0,
                'system' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'is_used_in_grid' => true,
                'is_global' => 1
            ]
        );
        $attribute = $this->config->getAttribute(
            ProductAttributeInterface::ENTITY_TYPE_CODE,
            self::ATTRIBUTE_CODE
        );
        $this->attribute->save($attribute);

        return $this;
    }
}
