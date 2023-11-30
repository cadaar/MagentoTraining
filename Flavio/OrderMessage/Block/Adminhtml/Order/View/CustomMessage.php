<?php declare(strict_types=1);

namespace Flavio\OrderMessage\Block\Adminhtml\Order\View;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Sales\Model\Order;

class CustomMessage extends Template
{
    public function __construct(
        Context $context,
        private readonly Registry $coreRegistry,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }
    public function getOrderCustomMessage()
    {
        /** @var Order $order */
        $order =  $this->coreRegistry->registry('current_order');
        $custom_message = $order->getData('custom_message');
        return $custom_message;
    }
}
