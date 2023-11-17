<?php declare(strict_types=1);

namespace Perficient\Assignment1\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Area;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\State;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

class AddBundleProduct implements DataPatchInterface
{
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly Product $productModel,
        private readonly StoreManagerInterface $storeManager,
        private readonly ProductFactory $productFactory,
        private readonly State $state,
    ) {}

    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->createProduct();
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     *
     * @return void
     * @throws LocalizedException
     */
    private function createProduct(): void
    {
        $categoryId = 5;
        $product = $this->productFactory->create();
        $attributeSetId = $this->productModel->getDefaultAttributeSetId();
        $product->setStoreId(Store::DEFAULT_STORE_ID);
        $product->setWebsiteIds([$this->storeManager->getDefaultStoreView()->getWebsiteId()]);
        $product->setTypeId('bundle');
        $product->setCategoryIds($categoryId);
        $instance = [
            'bundle_options' => [
                [
                    'title' => 'Option 1',
                    'required' => 1,
                    'type' => 'select',
                    'position' => 0,
                    'values' => [
                        '0' => [
                            'title' => 'Option 1 Value 1',
                            'price' => 0,
                            'price_type' => 'fixed',
                        ],
                        '1' => [
                            'title' => 'Option 1 Value 2',
                            'price' => 0,
                            'price_type' => 'fixed',
                        ],
                    ],
                ],
            ],
            'bundle_selections' => [
                [
                    'product_id' => 2038,
                    'selection_qty' => 1,
                    'selection_can_change_qty' => 0,
                    'position' => 0,
                    'is_default' => 1,
                    'selection_price_type' => 0,
                    'selection_price_value' => 0,
                    'option_id' => 0,
                ],
                [
                    'product_id' => 2004,
                    'selection_qty' => 1,
                    'selection_can_change_qty' => 0,
                    'position' => 0,
                    'is_default' => 1,
                    'selection_price_type' => 0,
                    'selection_price_value' => 0,
                    'option_id' => 0,
                ],
                [
                    'product_id' => 1928,
                    'selection_qty' => 1,
                    'selection_can_change_qty' => 0,
                    'position' => 0,
                    'is_default' => 1,
                    'selection_price_type' => 0,
                    'selection_price_value' => 0,
                    'option_id' => 0,
                ],
            ],
        ];
        $product->addData([
            'name' => 'Bundle Product by Flavio',//name of product
            'attribute_set_id' => $attributeSetId,
            'status' => Status::STATUS_ENABLED,
            'visibility' => Visibility::VISIBILITY_BOTH,
            'weight' => 0,
            'sku' => 'bundle_product_by_flavio',//SKU of product
            'tax_class_id' => 0,
            'price' => 0,
            'description' => 'Bundle product description',
            'short_description' => 'Bundle product short description',
            'type_instance' => $instance,
            'stock_data' => [ //stock management
                'manage_stock' => 1,
                'qty' => 999,
                'is_in_stock' => 1
            ]
        ]);

        $this->state->setAreaCode(Area::AREA_GLOBAL);
        $product->save();
    }

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [];
    }
}
