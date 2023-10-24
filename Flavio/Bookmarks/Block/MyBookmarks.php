<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Block;

use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;

class MyBookmarks extends Template
{
    public function __construct(
        private readonly Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    public function getDemoText()
    {
        return 'Your grid goes here...';
    }

}
