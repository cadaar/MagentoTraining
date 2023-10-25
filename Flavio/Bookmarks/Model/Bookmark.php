<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Model;

use Flavio\Bookmarks\Api\Data\BookmarkInterface;
use Magento\Framework\Model\AbstractModel;

class Bookmark extends AbstractModel implements BookmarkInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Bookmark::class);
    }

    public function getPageTitle()
    {
        return $this->getData(self::PAGE_TITLE);
    }

    public function setPageTitle($pageTitle)
    {
        return $this->setData(self::PAGE_TITLE, $pageTitle);
    }

    public function getUrl()
    {
        return $this->getData(self::URL);
    }

    public function setUrl($url)
    {
        return $this->setData(self::URL, $url);
    }

    public function getCustomerName()
    {
        return $this->getData(self::CUSTOMER_NAME);
    }

    public function setCustomerName($customerName)
    {
        return $this->setData(self::CUSTOMER_NAME, $customerName);
    }

    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }
}
