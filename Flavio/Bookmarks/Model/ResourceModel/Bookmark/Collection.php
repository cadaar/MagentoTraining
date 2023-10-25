<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Model\ResourceModel\Bookmark;

use Flavio\Bookmarks\Model\Bookmark;
use Flavio\Bookmarks\Api\Data\BookmarkInterface;
use Flavio\Bookmarks\Model\ResourceModel\Bookmark as BookmarkResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Bookmark::class, BookmarkResourceModel::class);
    }

    public function setCustomerIdFilter($customerId): self
    {
        $this->addFieldToFilter(BookmarkInterface::CUSTOMER_ID, $customerId);
        return $this;
    }

}
