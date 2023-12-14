<?php declare(strict_types=1);

namespace Flavio\ContactUs\Model\Resolver;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Framework\GraphQl\Query\Resolver\ArgumentsProcessorInterface;
use Magento\Quote\Api\Data\ShippingMethodInterface;
use Magento\Quote\Model\MaskedQuoteIdToQuoteId;
use Magento\Quote\Api\ShippingMethodManagementInterface;

use Magento\Quote\Model\Quote\Address\Total;
use Magento\QuoteGraphQl\Model\Cart\TotalsCollector;

class EstimatedShippingTaxesResolver implements ResolverInterface
{
    const FLAT_RATE = 50.0;
    const TABLE_RATE = 100.0;

    public function __construct(
        private readonly CartRepositoryInterface $quoteRepository,
        private readonly ArgumentsProcessorInterface $argsSelection,
        private readonly MaskedQuoteIdToQuoteId $maskedQuoteIdToQuoteId,
        //private readonly ShippingMethodManagementInterface $shippingMethodManagement,
        private readonly TotalsCollector $totalsCollector,
    ) {}

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null): array
    {
        $processedArgs = $this->argsSelection->process('cart_id', $args);
        if (empty($processedArgs['cart_id'])) {
            throw new GraphQlInputException(__('Required parameter "cart_id" is missing.'));
        }
        $maskedCartId = $processedArgs['cart_id'];
        try {
            $cartId = $this->maskedQuoteIdToQuoteId->execute($maskedCartId);
        } catch (NoSuchEntityException $exception) {
            throw new GraphQlNoSuchEntityException(
                __('Could not find a cart with ID "%masked_cart_id"', ['masked_cart_id' => $maskedCartId])
            );
        }
        $storeId = (int) $context->getExtensionAttributes()->getStore()->getId();
        $estimatedShippingTax = 0;
        $grandTotal = 0;
        $currency = '';
        $estimatedShippingRate = 0;

        try {
            if($cartId){
                $quote = $this->quoteRepository->get($cartId);
                //$shippingMethods = $this->shippingMethodManagement->getList($cartId);

                //$carrierCode = $this->getShippingMethodCarrierCode($quote);

                //$isFlatRate = $this->isFlatRate($carrierCode);

                $estimatedShippingTax = $this->getEstimatedShippingTax($quote);

                // /** @var \Magento\Quote\Model\Quote\Address\Total $cartTotals */
                $cartTotals = $this->totalsCollector->collectQuoteTotals($quote);
                $estimatedShippingRate = $this->getEstimatedShippingRate($quote);
                $grandTotal = $cartTotals->getGrandTotal() + $estimatedShippingTax;
                $currency = $quote->getQuoteCurrencyCode();
            }
        } catch (LocalizedException $e) {
            throw new GraphQlNoSuchEntityException(
                __('Unable to remove item')
            );
        }

        return [
            'estimated_shipping_rate' => ['value' => $estimatedShippingRate, 'currency' => $currency],
            'estimated_tax' => ['value' => $estimatedShippingTax, 'currency' => "USD"],
            'subtotal_including_tax' => ['value' => $cartTotals->getSubtotalInclTax(), 'currency' => $currency],
            'subtotal_excluding_tax' => ['value' => $cartTotals->getSubtotal(), 'currency' => $currency],
            'grand_total' => ['value' => $grandTotal, 'currency' => $currency],
        ];
    }

    private function getEstimatedShippingTax($quote): float
    {
        $carrierCode = $this->getShippingMethodCarrierCode($quote);
        return $this->isFlatRate($carrierCode) ? self::FLAT_RATE : ($this->isTableRate($carrierCode) ? self::TABLE_RATE : 0);
    }

    private function isFlatRate($carrierCode): bool
    {
        return $carrierCode == 'flatrate';
    }

    private function isTableRate($carrierCode): bool
    {
        return $carrierCode == 'tablerate';
    }

    private function getShippingMethodCarrierCode($quote): string
    {
        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();

        $shippingMethodArr = explode('_', $shippingMethod);

        return $shippingMethodArr[0];
    }

    private function getEstimatedShippingRate($quote): float
    {
        return $quote->getShippingAddress()->getShippingAmount();
    }

}
