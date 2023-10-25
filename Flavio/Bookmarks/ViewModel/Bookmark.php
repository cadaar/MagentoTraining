<?php declare(strict_types=1);

namespace Flavio\Bookmarks\ViewModel;

use Flavio\Bookmarks\Model\ResourceModel\Bookmark\Collection;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;

class Bookmark implements ArgumentInterface
{
    public function __construct(
        private readonly Collection $collection,
        private readonly CurrentCustomer $currentCustomer,
    ) {}
    public function getList(): array
    {
        $id = $this->currentCustomer->getCustomerId();
        return $this->collection->setCustomerIdFilter($id)->getItems();
    }

}
