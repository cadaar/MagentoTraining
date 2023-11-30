<?php declare(strict_types=1);

namespace Flavio\OrderMessage\Controller\Quote;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Quote\Api\CartRepositoryInterface;

class Save extends Action
{
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        private readonly QuoteIdMaskFactory $quoteIdMaskFactory,
        private readonly CartRepositoryInterface $quoteRepository
    ) {
        parent::__construct($context);
    }

    public function execute(): void
    {
        $post = $this->getRequest()->getPostValue();
        if ($post) {
            $cartId = $post['cartId'];
            $customMessage = $post['customMessage'];
            $isCustomer = $post['is_customer'];

            if ($isCustomer === 'false') {
                $cartId = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id')->getQuoteId();
            }

            $quote = $this->quoteRepository->getActive($cartId);
            if (!$quote->getItemsCount()) {
                throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
            }

            $quote->setData('custom_message', $customMessage);
            $this->quoteRepository->save($quote);
        }
    }
}
