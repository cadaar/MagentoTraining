<?php declare(strict_types=1);

namespace Flavio\OrderMessage\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class SaveToOrder implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $event = $observer->getEvent();
        $quote = $event->getQuote();
        $order = $event->getOrder();

        $custom_message = $quote->getData('custom_message');

        if ($custom_message == "") {
            $custom_message = "no message from quote, this is hardcoded.";
        }

        $order->setData('custom_message', $custom_message);
    }
}
