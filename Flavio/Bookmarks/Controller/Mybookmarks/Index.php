<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Controller\Mybookmarks;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    const CMS_BLOCK_IDENTIFIER = 'MyBookmarksWelcomeMessage';

    public function __construct(
        private readonly PageFactory $pageFactory,
    ){}

    public function execute(): Page
    {
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->set('My Bookmarks');
        return $page;
    }
}

