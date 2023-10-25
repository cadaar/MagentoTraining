<?php declare(strict_types=1);

namespace Flavio\Bookmarks\ViewModel;

use Flavio\Bookmarks\Api\BookmarksRepositoryInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;

class Bookmark implements ArgumentInterface
{
    public function __construct(
        private readonly CurrentCustomer $currentCustomer,
        private readonly BookmarksRepositoryInterface $repository,
    ) {}
    public function getList(): array
    {
        $id = (int)$this->currentCustomer->getCustomerId();
        return $this->repository->getCollectionByCustomerId($id);
    }

}
