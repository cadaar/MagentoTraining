<?php declare(strict_types=1);

namespace Flavio\Bookmarks\Setup\Patch\Data;

use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\Store;

class AddCmsBlockForBookmarkMessage implements DataPatchInterface
{
    const CMS_BLOCK_IDENTIFIER = 'MyBookmarksWelcomeMessage';
    public function __construct(
        private readonly BlockFactory $blockFactory,
        private readonly ModuleDataSetupInterface $moduleDataSetup,
    ){}

    public function apply(): self
    {
        $cmsBlockData = [
            'title' => 'These are your favorite pages',
            'identifier' => self::CMS_BLOCK_IDENTIFIER,
            'content' => '<style>#html-body [data-pb-style=J2URTK4]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="J2URTK4"><div data-content-type="text" data-appearance="default" data-element="main"><p style="line-height: 20px;"><span style="color: #236fa1; font-size: 28px;">These are your favorite pages</span></p></div></div></div>',
            'is_active' => 1,
            'stores' => [Store::DEFAULT_STORE_ID],
        ];

        $this->blockFactory->create()->setData($cmsBlockData)->save();

        return $this;
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return  [];
    }
}
