<?php declare(strict_types=1);

namespace Flavio\CustomCheckout\Plugin;

use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Address\ToOrderAddress;
use Magento\Sales\Api\Data\OrderAddressInterface;

class ConvertQuoteToOrderAddress
{
    public function afterConvert(
        ToOrderAddress $subject,
        OrderAddressInterface $result,
        Address $address
    ): OrderAddressInterface
    {
        if ($addressClassification = $address->getData('address_classification')) {
            $result->setData('address_classification', $addressClassification);
        }

        return $result;
    }
}
