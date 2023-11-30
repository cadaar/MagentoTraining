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

        $order->setData('custom_message', $custom_message);
    }
}
