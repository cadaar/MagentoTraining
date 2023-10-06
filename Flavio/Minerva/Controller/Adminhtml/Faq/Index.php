<?php declare(strict_types=1);

namespace Flavio\Minerva\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Flavio_Minerva::faq';

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

        $page->setActiveMenu('Flavio_Minerva::faq');
        $page->getConfig()->getTitle()->prepend(__('FAQs'));

        return $page;
    }
}
