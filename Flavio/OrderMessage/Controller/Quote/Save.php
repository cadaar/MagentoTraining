<?php declare(strict_types=1);

namespace Flavio\OrderMessage\Controller\Quote;

use Exception;
use Magento\Framework\Controller\Result\Json;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\App\Request\Http;

class Save implements HttpPostActionInterface
{
    private const HTTP_OK = 200;
    private const HTTP_BAD_REQUEST = 400;
    private const HTTP_INTERNAL_ERROR = 500;

    public function __construct(
        private readonly QuoteIdMaskFactory $quoteIdMaskFactory,
        private readonly CartRepositoryInterface $quoteRepository,
        private readonly ResultFactory $resultFactory,
        private readonly Http $request,
    ) {}

    public function execute(): Json
    {
        $responseCode = self::HTTP_INTERNAL_ERROR;
        $responseContent = [];

        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        try {
            $params = $this->request->getParams();
            if ($params) {
                $cartId = $params['cartId'] ?? null;
                $customMessage = $params['customMessage'] ?? "";
                $isCustomer = $params['is_customer'];

                if (empty($cartId)) {
                    $responseContent = [
                        'success' => false,
                        'message' => __('A cart is required to save the quote.'),
                    ];
                    $resultJson->setHttpResponseCode(self::HTTP_BAD_REQUEST);
                    $resultJson->setData($responseContent);

                    return $resultJson;
                }

                if ($isCustomer === 'false') {
                    $cartId = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id')->getQuoteId();
                }

                $quote = $this->quoteRepository->getActive($cartId);
                if (!$quote->getItemsCount()) {
                    throw new NoSuchEntityException(__('Cart %1 does not contain products', $cartId));
                }

                $quote->setData('custom_message', $customMessage);
                $this->quoteRepository->save($quote);

                $responseCode = self::HTTP_OK;
                $responseContent = [
                    'success' => true,
                    'message' => __('Custom message saved on quote.'),
                ];
            }
        } catch (NoSuchEntityException|Exception $exception) {
            $responseCode = self::HTTP_INTERNAL_ERROR;
            $responseContent = [
                'success' => false,
                'message' => __($exception->getMessage()),
            ];
        }

        $resultJson->setHttpResponseCode($responseCode);
        $resultJson->setData($responseContent);

        return $resultJson;
    }
}
