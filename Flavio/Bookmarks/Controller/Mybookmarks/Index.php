<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Controller\Mybookmarks;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Cms\Api\BlockRepositoryInterface;

class Index implements HttpGetActionInterface
{
    const CMS_BLOCK_IDENTIFIER = 'MyBookmarksWelcomeMessage';

    public function __construct(
        private readonly PageFactory $pageFactory,
        private readonly BlockRepositoryInterface $blockRepository,
    ){}

    public function execute(): Page
    {
        $page = $this->pageFactory->create();
        $block = $this->blockRepository->getById(self::CMS_BLOCK_IDENTIFIER);
        $title = $block->getTitle();
        $page->getConfig()->getTitle()->set($title ?? 'My Bookmarks');
        return $page;
    }
}

