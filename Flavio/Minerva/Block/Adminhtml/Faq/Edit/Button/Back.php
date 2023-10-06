<?php declare(strict_types=1);

namespace Flavio\Minerva\Block\Adminhtml\Faq\Edit\Button;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Back implements ButtonProviderInterface
{
    public function __construct(
        private readonly UrlInterface $urlBuilder
    ) {}

    public function getButtonData(): array
    {
        $url = $this->urlBuilder->getUrl('*/*/');

        return [
            'label' => __('Back'),
            'class' => 'back',
            'on_click' => sprintf("location.href='%s';", $url)
        ];
    }
}
