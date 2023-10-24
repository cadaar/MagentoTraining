<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Model\ResourceModel\Bookmark;

use Flavio\Bookmarks\Model\Bookmark;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Bookmark::class, \Flavio\Bookmarks\Model\ResourceModel\Bookmark::class);
    }
}
