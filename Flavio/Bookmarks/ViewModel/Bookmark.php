<?php declare(strict_types=1);

namespace Flavio\Bookmarks\ViewModel;

use Flavio\Bookmarks\Api\BookmarksRepositoryInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Bookmark implements ArgumentInterface
{
    public function __construct(
        private readonly CurrentCustomer $currentCustomer,
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly BookmarksRepositoryInterface $repository,
    ) {}

    public function getList(): array
    {
        $currentCustomerId = (int)$this->currentCustomer->getCustomerId();
        return $this->repository->getCollectionByCustomerId($currentCustomerId);
    }

    public function isCustomerBookmarksOn():bool
    {
        $value = $this->scopeConfig->getValue('bookmarks_for_customers/general/enable');
        return ((isset($value) && $value == "1"));
    }

}
