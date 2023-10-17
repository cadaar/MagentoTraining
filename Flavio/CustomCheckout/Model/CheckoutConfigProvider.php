<?php declare(strict_types=1);

namespace Flavio\CustomCheckout\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\LayoutInterface;

class CheckoutConfigProvider implements ConfigProviderInterface
{
    private $fulfillmentStatus;
    public function __construct(
        private readonly LayoutInterface $layout
    )
    {
        $this->fulfillmentStatus = $this->layout->createBlock('Magento\Cms\Block\Block')
            ->setBlockId('fulfillment_status')->toHtml();
    }

    public function getConfig(): array
    {
        return [
            'fulfillment_status' => $this->fulfillmentStatus,
        ];
    }
}
