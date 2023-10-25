<?php declare(strict_types=1);

namespace Flavio\Bookmarks\ViewModel;

use Flavio\Bookmarks\Api\BookmarksRepositoryInterface;
use Flavio\Bookmarks\Api\Data\BookmarkInterface;
use Flavio\Bookmarks\Model\ResourceModel\Bookmark\Collection;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class Bookmark implements ArgumentInterface
{
    public function __construct(
        private readonly Collection $collection,
        private readonly BookmarksRepositoryInterface $repository,
        private readonly RequestInterface $request,
    ) {}
    public function getList(): array
    {
        $collection = $this->collection->setCustomerIdFilter('2')->getItems();

        return $collection;// $this->collection->getItems();
    }

    public function getBookmark(): BookmarkInterface
    {
        $r = $this->repository->getById(3);
        return $this->repository->getById(3);
    }
}
