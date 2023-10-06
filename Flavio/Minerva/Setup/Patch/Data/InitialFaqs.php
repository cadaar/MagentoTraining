<?php declare(strict_types=1);

namespace Flavio\Minerva\Setup\Patch\Data;

use Flavio\Minerva\Model\ResourceModel\Faq;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class InitialFaqs implements DataPatchInterface
{
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly ResourceConnection $resourceConnection
    ){}

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply(): self
    {
        $connection = $this->resourceConnection->getConnection();
        $data = [
            [
                'question' => 'What is your best selling item?',
                'answer' => 'The item you buy!',
                'is_published' => 1
            ],
            [
                'question' => 'What is your quest?',
                'answer' => 'Found the time traveling secret',
                'is_published' => 0
            ],
            [
                'question' => 'What is your customer support number?',
                    'answer' => '0118 999 881 999 119 725... 3. Ask for Jenny!',
                'is_published' => 1
            ]
        ];

        $connection->insertMultiple(Faq::MAIN_TABLE, $data);

        return $this;
    }
}
