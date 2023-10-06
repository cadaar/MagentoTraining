<?php declare(strict_types=1);

namespace Flavio\Minerva\Controller\Adminhtml\Faq;


use Flavio\Minerva\Model\Faq;
use Flavio\Minerva\Model\FaqFactory;
use Flavio\Minerva\Model\ResourceModel\Faq as FaqResource;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Delete extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Flavio_Minerva::faq_delete';

    /** @var FaqFactory */
    protected $faqFactory;

    /** @var FaqResource */
    protected $faqResource;

    public function __construct(
        Context $context,
        FaqFactory $factory,
        FaqResource $faqResource

    ) {
        $this->faqFactory = $factory;
        $this->faqResource = $faqResource;
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        try {
            $id = $this->getRequest()->getParam('id');
            /** @var Faq $faq */
            $faq = $this->faqFactory->create();
            $this->faqResource->load($faq, $id);

            if ($faq->getId()) {
                $this->faqResource->delete($faq);
                $this->messageManager->addSuccessMessage(__('The record has been deleted.'));
            } else {
                $this->messageManager->addErrorMessage(__('The record does not exists.'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        /** @var Redirect $redirect */
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $redirect->setPath('*/*');
    }
}
