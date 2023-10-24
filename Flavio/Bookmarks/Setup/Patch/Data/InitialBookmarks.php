<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Setup\Patch\Data;

use Flavio\Bookmarks\Model\ResourceModel\Bookmark;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class InitialBookmarks implements DataPatchInterface
{
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly ResourceConnection $resourceConnection
    ){}

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }

    public function apply(): self
    {
        $connection = $this->resourceConnection->getConnection();
        $data = [
            [
                'customer_id' => 2,
                'customer_name' => 'Flavio Perez',
                'url' => 'https://magento.test/gear/bags.html',
                'page_title' => 'Bags - Gear'
            ],
            [
                'customer_id' => 1,
                'customer_name' => 'Veronica Costello',
                'url' => 'https://magento.test/women/bottoms-women/pants-women.html',
                'page_title' => 'Pants - Bottoms'
            ],
            [
                'customer_id' => 2,
                'customer_name' => 'Flavio Perez',
                'url' => 'https://magento.test/training.html',
                'page_title' => 'Training'
            ],
            [
                'customer_id' => 1,
                'customer_name' => 'Veronica Costello',
                'url' => 'https://magento.test/men/tops-men/hoodies-and-sweatshirts-men.html',
                'page_title' => 'Hoodies & Sweatshirts - Tops - Men'
            ],
            [
                'customer_id' => 2,
                'customer_name' => 'Flavio Perez',
                'url' => 'https://magento.test/men/tops-men/hoodies-and-sweatshirts-men.html',
                'page_title' => 'Hoodies & Sweatshirts - Tops - Men'
            ],

        ];

        $connection->insertMultiple(Bookmark::MAIN_TABLE, $data);

        return $this;
    }
}
