<?php declare(strict_types=1);

namespace Flavio\Bookmarks\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Flavio\Bookmarks\Api\BookmarksRepositoryInterface;

class BookmarksSection implements SectionSourceInterface
{
    public function __construct(
        private readonly BookmarksRepositoryInterface $repository,
    ) {}

    /**
     * {@inheritdoc}
     */
    public function getSectionData(): array
    {
        $bookmarks = $this->repository->getCurrentCustomerBookmarks();
        $data = [];
        foreach ($bookmarks as $bookmark) {
            $data[] = $bookmark->getData();
        }

        return $data;
    }
}
