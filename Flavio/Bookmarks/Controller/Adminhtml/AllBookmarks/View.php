<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Controller\Adminhtml\AllBookmarks;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class View extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Flavio_Bookmarks::all_bookmarks_view';

    public function __construct(
        private readonly Context $context,
        private readonly PageFactory $pageFactory
    )
    {
        parent::__construct($this->context);
    }

    public function execute(): Page
    {
        $page = $this->pageFactory->create();

        $page->setActiveMenu('Flavio_Bookmarks::all_bookmarks');
        $page->getConfig()->getTitle()->prepend(__('Bookmark Detail'));

        return $page;
    }
}
