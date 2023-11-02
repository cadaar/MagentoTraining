<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Controller\Mybookmarks;

use Flavio\Bookmarks\Model\Bookmark;
use Flavio\Bookmarks\Model\BookmarkFactory;
use Flavio\Bookmarks\Model\ResourceModel\Bookmark as BookmarkResource;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;

class GridPost extends Action implements HttpPostActionInterface
{
    public function __construct(
        private readonly Context $context,
        private readonly BookmarkFactory $bookmarkFactory,
        private readonly BookmarkResource $bookmarkResource
    )
    {
        parent::__construct($this->context);
    }

    public function execute(): Redirect
    {
        try {
            $id = $this->getRequest()->getParam('id');
            /** @var Bookmark $record */
            $record = $this->bookmarkFactory->create();
            $this->bookmarkResource->load($record, $id);

            if ($record->getId()) {
                $this->bookmarkResource->delete($record);
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
