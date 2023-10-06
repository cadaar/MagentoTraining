<?php declare(strict_types=1);

namespace Flavio\Minerva\Ui\DataProvider;

use Flavio\Minerva\Model\ResourceModel\Faq\Collection;
use Flavio\Minerva\Model\ResourceModel\Faq\CollectionFactory;

use Magento\Ui\DataProvider\AbstractDataProvider;

class Faq extends AbstractDataProvider
{
    /** @var Collection $collection */
    protected $collection;

    /** @var array  */
    private array $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create();
    }

    public function getData(): array
    {
        if (!isset($this->loadedData)) {
            $this->loadedData = [];

            foreach ($this->collection->getItems() as $item) {
                $this->loadedData[$item->getData('id')] = $item->getData();
            }
        }
        return $this->loadedData;
    }
}
