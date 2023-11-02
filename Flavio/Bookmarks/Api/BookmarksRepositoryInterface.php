<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Api;

use Flavio\Bookmarks\Api\Data\BookmarkInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Bookmark CRUD interface.
 * @api
 * @since 1.0.0
 */
interface BookmarksRepositoryInterface
{
    /**
     * @param int $id
     * @return BookmarkInterface
     * @throws LocalizedException
     */
    public function getById(int $id): BookmarkInterface;

    /**
     * @param string $url
     * @return BookmarkInterface
     * @throws LocalizedException
     */
    public function getByUrl(string $url): BookmarkInterface;

    /**
     * @param BookmarkInterface $bookmark
     * @return BookmarkInterface
     * @throws LocalizedException
     */
    public function save(BookmarkInterface $bookmark): BookmarkInterface;

    /**
     * @param int $id
     * @return bool
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool;

    /**
     * @param int $customerId
     * @return array
     */
    public function getCollectionByCustomerId(int $customerId): array;
}
