<?php declare(strict_types=1);

namespace Flavio\Minerva\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;

use Flavio\Minerva\Model\FaqFactory;
use Flavio\Minerva\Model\ResourceModel\Faq\CollectionFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Flavio_Minerva::faq_delete';

    /** @var CollectionFactory */
    protected $collectionFactory;

    /** @var Filter */
    protected $filter;

    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        Filter $filter
    )
    {
        parent::__construct($context);

        $this->collectionFactory = $collectionFactory;
        $this->filter = $filter;
    }

    public function execute(): Redirect
    {
        $collection = $this->collectionFactory->create();
        $items = $this->filter->getCollection($collection);
        $itemsSize = $items->getSize();

        foreach ($items as $item) {
            $item->delete();
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $itemsSize));

        /** @var Redirect $redirect */
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $redirect->setPath('*/*');
    }
}
