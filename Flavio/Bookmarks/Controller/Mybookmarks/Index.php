<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Controller\Mybookmarks;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    public function __construct(
        private readonly PageFactory $pageFactory,
        private readonly ResultFactory $resultFactory,
        private readonly ScopeConfigInterface $scopeConfig,
    ){}

    public function execute()
    {
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->set('My Bookmarks');

        $value = $this->scopeConfig->getValue('bookmarks_for_customers/general/enable');

        $isBookmarkParameterOn = ((isset($value) && $value == "1"));

        if ($isBookmarkParameterOn) {
            return $page;
        }
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $redirect->setPath('about-us');
    }
}

