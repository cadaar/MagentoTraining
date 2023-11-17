<?php declare(strict_types=1);

/**
 * Created By: Flavio Perez for Perficient training.
 */

namespace Perficient\Assignment1\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Area;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\State;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable\Attribute;

use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Catalog\Setup\CategorySetup;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;

class AddConfigProduct implements DataPatchInterface
{
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly Product $productModel,
        private readonly StoreManagerInterface $storeManager,
        private readonly ProductFactory $productFactory,
        private readonly State $state,
        private readonly Attribute $attribute,
        private readonly AttributeRepositoryInterface $attributeRepository,
        private readonly CategorySetup $categorySetup,
    ) {}

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        try {
            $this->createProduct();
        } catch (\Exception $e) {
            $this->logMessage($e->getMessage());
        } finally {
            $this->moduleDataSetup->getConnection()->endSetup();
        }

    }

    private function logMessage($message): void
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/patch-errors.log');
        $logger = new \Zend_Log();

        $logger->addWriter($writer);
        $logger->info(__METHOD__ . 'begin>> ' . $message . ' <<end');
    }

    private function createProduct(): void
    {
        $categoryId = 12;
        $product = $this->productFactory->create();
        $attributeSetId = $this->productModel->getDefaultAttributeSetId();
        $product->setStoreId(Store::DEFAULT_STORE_ID);
        $product->setWebsiteIds([$this->storeManager->getDefaultStoreView()->getWebsiteId()]);
        $product->setTypeId(Configurable::TYPE_CODE);
        $product->setCategoryIds($categoryId);
        $product->addData([
            'name' => 'Product Configurable created by Flavio 2',//name of product
            'attribute_set_id' => $attributeSetId,
            'status' => Status::STATUS_ENABLED,
            'visibility' => Visibility::VISIBILITY_BOTH,
            'weight' => 50,
            'sku' => 'ZZZ-456-987-36',//SKU of product
            'tax_class_id' => 0,
            'price' => 100,
            'description' => 'Configurable product description',
            'short_description' => 'Conf product short description',
            'stock_data' => [ //stock management
                'manage_stock' => 1,
                'qty' => 999,
                'is_in_stock' => 1
            ]
        ]);

        $this->state->setAreaCode(Area::AREA_GLOBAL);
        $product->save();

        $colorAttribute = [
            'attribute_id' => 93, //color
            'product_id' => $product->getEntityId(),
            'position' => 1
        ];

        $sizeAttribute = [
            'attribute_id' => 144, //size
            'product_id' => $product->getEntityId(),
            'position' => 2
        ];

        $this->attribute->setData($colorAttribute)->save();
        $this->attribute->setData($sizeAttribute)->save();

        $product->setAssociatedProductIds([620,621,622]);
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
