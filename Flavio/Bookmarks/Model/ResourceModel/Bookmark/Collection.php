<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Model\ResourceModel\Bookmark;

use Flavio\Bookmarks\Model\Bookmark;
use Flavio\Bookmarks\Api\Data\BookmarkInterface;
use Flavio\Bookmarks\Model\ResourceModel\Bookmark as BookmarkResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Collection extends AbstractCollection
{
    public function __construct(
        private readonly EntityFactoryInterface $entityFactory,
        private readonly LoggerInterface $logger,
        private readonly FetchStrategyInterface $fetchStrategy,
        private readonly ManagerInterface $eventManager,
        private readonly StoreManagerInterface $storeManager,
        private readonly ?AdapterInterface $connection = null,
        private readonly ?AbstractDb $resource = null
    ) {
        $this->_init(Bookmark::class, BookmarkResourceModel::class);

        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    public function setCustomerIdFilter($customerId): self
    {
        $this->addFieldToFilter(BookmarkInterface::CUSTOMER_ID, $customerId);
        return $this;
    }

    public function setUrlToFilter($url): self
    {
        $this->addFieldToFilter(BookmarkInterface::URL, $url);
        return $this;
    }

    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()->joinLeft(
            ['secondTable' => $this->getTable('customer_entity')],
            'main_table.customer_id = secondTable.entity_id',
            [
                'main_table.id',
                'main_table.customer_id',
                //'customer_name' => "CONCAT(secondTable.firstname, ' ', secondTable.lastname) as FullName",
                "CONCAT(secondTable.firstname, ' ', secondTable.lastname) as customer_name",
                'main_table.page_title',
                'main_table.url'
            ]
        );

        $this->getSelect()->columns('CONCAT(secondTable.firstname," ",secondTable.lastname) as customer_name');
        $this->addFilterToMap('customer_name', "CONCAT(secondTable.firstname, ' ', secondTable.lastname) as customer_name");

        return $this;
    }

}
