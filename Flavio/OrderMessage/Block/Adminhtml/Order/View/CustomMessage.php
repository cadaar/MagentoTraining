<?php declare(strict_types=1);

namespace Flavio\OrderMessage\Block\Adminhtml\Order\View;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;

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
        $order =  $this->coreRegistry->registry('current_order');
        return $order->getData('custom_message');
    }
}
