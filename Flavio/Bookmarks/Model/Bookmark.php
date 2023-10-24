<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Model;

use Magento\Framework\Model\AbstractModel;

class Bookmark extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Bookmark::class);
    }
}
