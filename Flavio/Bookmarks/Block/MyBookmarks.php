<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Block;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class MyBookmarks extends Template
{
    public function __construct(
        private readonly Context $context,
        private readonly ScopeConfigInterface $scopeConfig,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    public function getConfigValue($value = '')
    {
        return $this->scopeConfig->getValue($value);
    }

}
