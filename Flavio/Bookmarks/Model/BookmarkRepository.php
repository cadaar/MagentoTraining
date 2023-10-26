<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Model;

use Flavio\Bookmarks\Api\Data\BookmarkInterface;
use Flavio\Bookmarks\Model\ResourceModel\Bookmark as BookmarkResourceModel;
use Flavio\Bookmarks\Api\BookmarksRepositoryInterface;
use Flavio\Bookmarks\Model\ResourceModel\Bookmark\CollectionFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class BookmarkRepository implements BookmarksRepositoryInterface
{
    public function __construct(
        private BookmarkFactory $factory,
        private BookmarkResourceModel $resourceModel,
        private readonly CollectionFactory $collectionFactory,
    ) {}

    public function getById(int $id): BookmarkInterface
    {
        $bookmark = $this->factory->create();
        $this->resourceModel->load($bookmark, $id);

        if (!$bookmark->getId()) {
            throw new NoSuchEntityException(__('Bookmark ID "%1" doesn\'t exist.', $id));
        }

        return $bookmark;
    }

    public function save(BookmarkInterface $bookmark): BookmarkInterface
    {
        try {
            $this->resourceModel->save($bookmark);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $bookmark;
    }

    public function deleteById(int $id): bool
    {
        $record = $this->getById($id);

        try {
            $this->resourceModel->delete($record);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    public function getCollectionByCustomerId(int $customerId): array
    {
        $collection = $this->collectionFactory->create();
        return $collection->setCustomerIdFilter($customerId)->getItems();
    }
}
