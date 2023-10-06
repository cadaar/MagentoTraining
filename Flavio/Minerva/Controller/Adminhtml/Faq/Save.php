<?php declare(strict_types=1);

namespace Flavio\Minerva\Controller\Adminhtml\Faq;

use Flavio\Minerva\Model\Faq;
use Flavio\Minerva\Model\FaqFactory;
use Flavio\Minerva\Model\ResourceModel\Faq as FaqResource;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;

class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Flavio_Minerva::faq_save';

    public function __construct(
        private readonly Context $context,
        private readonly FaqFactory $faqFactory,
        private readonly FaqResource $faqResource
    )
    {
        parent::__construct($this->context);
    }

    public function execute(): Redirect
    {
        // Get post data
        $post = $this->getRequest()->getPost();
//        echo '<pre>';
//        var_dump($post);
//        echo '</pre>';
//        die();

        /** @var Faq $faq */
        $faq = $this->faqFactory->create();
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        // Determine if this is a new or existing record
        $isExistingPost = $post->id;
        if ($isExistingPost) {
            try {
                // If existing, load data from database and merge with the posted data
                $this->faqResource->load($faq, $post->id);

                // Not found? Thrown an exception, display message to the user & redirect back
                if (!$faq->getData('id')) {
                    throw new NotFoundException(__('This record not longer exists.'));
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $redirect->setPath('*/*/');
            }
        } else {
            // If new, build an object with the posted data to save it
            unset($post->id); // so the id will be automatically generated.
        }

        // if $faq->getData is null, will be populated with the postData
        $faq->setData(array_merge($faq->getData(), $post->toArray()));

        // Save the data, and tell the user it's been saved
        // If problem saving the data, display error message to the user
        try {
            $this->faqResource->save($faq);
            $this->messageManager->addSuccessMessage(__('The record has been saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $redirect->setPath('*/*/');
        }

        // On success, redirect back to the admin grid.
        return $redirect->setPath('*/*/');
    }
}
